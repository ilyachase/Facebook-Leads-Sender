<?php

namespace app\commands;

use app\models\Activerecord\Connections;
use app\models\Adf\FBLeadsHelper;
use app\models\Adf\Leadfieldshelper;
use app\models\ADFGenerator;
use app\models\Activerecord\Destinations;
use app\models\FbToken;
use app\models\Activerecord\Rulesets;
use FacebookAds\Api;
use FacebookAds\Http\RequestInterface;
use FacebookAds\Object\LeadgenForm;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;

class AdfController extends Controller
{
    /** @var bool */
    public $debug = false;

    public function options( $actionID )
    {
        return [ 'debug' ];
    }

    /** @var FbToken */
    private $_fbToken;

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws Exception
     */
    public function beforeAction( $action )
    {
        if ( !parent::beforeAction( $action ) )
            return false;

        $this->_fbToken = new FbToken();
        if ( !( $token = $this->_fbToken->getToken() ) )
        {
            throw new Exception( "Can't get access token. May be you should renew it from web side?" );
        }

        Api::init(
            Yii::$app->params[PARAMS_FB_APP_ID],
            Yii::$app->params[PARAMS_FB_APP_SECRET],
            $token
        );

        return true;
    }

    public function actionIndex()
    {
        $currentMinutes = (int) date( 'G' ) * 60 + (int) date( 'i' );
        $generator = new ADFGenerator();
        $this->log( "ADF generation script started working." );
        $this->log( "Current minutes: $currentMinutes" );

        foreach ( Yii::$app->params[PARAMS_CONNECTIONS_CHECK_INTERVALS] as $interval => $label )
        {
            if ( $currentMinutes % $interval !== 0 )
                continue;

            $new_connections = ArrayHelper::index( Connections::find()->where( [ 'last_time_checked' => null, 'is_active' => true ] )->all(), 'id' );
            $connections_by_time = ArrayHelper::index( Connections::find()->where( [ 'check_interval' => $interval, 'is_active' => true ] )->all(), 'id' );
            $connections = $new_connections + $connections_by_time;

            /**
             * @var Connections[] $connections
             */
            foreach ( $connections as $connection )
            {
                $this->log( "Found connection with id = $connection->id" );
                $connection->last_time_checked = Yii::$app->formatter->asDatetime( time(), FORMATTER_MYSQL_DATETIME_FORMAT );
                $connection->save();

                $connectionLastLeadTimestamp = (int) Yii::$app->formatter->asTimestamp( $connection->last_lead_time );

                $ruleset = Rulesets::findOne( $connection->ruleset_id );
                if ( !$ruleset )
                    throw new Exception( "Can't find ruleset with id $connection->ruleset_id for connection $connection->id" );

                $destination = Destinations::findOne( [ 'id' => $connection->destination_id ] );
                if ( !$destination )
                    throw new Exception( "Can't find destination with id $connection->destination_id for connection $connection->id" );

                $formFields = Api::instance()->call( "/$ruleset->leadform_id", RequestInterface::METHOD_GET, [ 'fields' => 'id,name,qualifiers' ] )->getContent();
                $fieldsHelper = new Leadfieldshelper( $formFields['qualifiers'], $ruleset->fieldConnections );

                $leads = ( new LeadgenForm( $ruleset->leadform_id ) )->getLeads();
                $leadsHelper = new FBLeadsHelper( $leads );
                if ( !$leads->count() )
                {
                    $this->log( "Form $ruleset->leadform_id have no leads. Continue..." );
                    continue;
                }

                if ( $leadsHelper->getLastLeadTimestamp() <= $connectionLastLeadTimestamp )
                {
                    $this->log( "Form $ruleset->leadform_id have no new leads. Continue..." );
                    continue;
                }

                /** @var \FacebookAds\Object\Lead $lead */
                $leadsSendedCounter = 0;
                $adfData = [];
                foreach ( $leadsHelper->getLeadsAfterTimestamp( $connectionLastLeadTimestamp ) as $lead )
                {
                    $lead = $lead->getData();
                    $leadData = $fieldsHelper->getAdfFieldsByLead( $lead['field_data'] );
                    if ( empty( $leadData ) )
                        continue;

                    if ( \DateTime::createFromFormat( \DateTime::W3C, $lead['created_time'] )->getTimestamp() <= $connectionLastLeadTimestamp )
                        continue;

                    $adfData[] = $leadData;

                    $leadCreatedTime = \DateTime::createFromFormat( \DateTime::W3C, $lead['created_time'] );
                    if ( $leadCreatedTime->getTimestamp() > $connectionLastLeadTimestamp )
                    {
                        $connection->last_lead_time = $leadCreatedTime->format( MYSQL_DATETIME_FORMAT );
                    }

                    $leadsSendedCounter++;
                }

                $xmlString = $generator->generateADF( $adfData );

                $message = \Yii::$app->mailer->compose()
                    ->setTo( $destination->email_to )
                    ->setSubject( $destination->subject )
                    ->setTextBody( $xmlString );

                if ( $destination->email_from )
                {
                    $message->setFrom( $destination->email_from );
                }
                else
                {
                    $message->setFrom( DEFAULT_EMAIL_FROM );
                }

                if ( $destination->cc )
                    $message->setCc( $destination->cc );

                if ( $destination->bcc )
                    $message->setBcc( $destination->bcc );

                $message->send();

                $connection->save();

                $this->log( "Sended $leadsSendedCounter leads to $destination->email_to." );
            }
        }

        $this->log( "Done." );
    }

    /**
     * @param string $message
     * @param bool $eol
     */
    private function log( $message, $eol = true )
    {
        if ( !$this->debug )
            return;

        echo $message . ( $eol ? PHP_EOL : '' );
    }
}