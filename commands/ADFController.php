<?php

namespace app\commands;

use app\models\activerecord\Connections;
use app\models\adf\Leadfieldshelper;
use app\models\ADFGenerator;
use app\models\FbToken;
use app\models\activerecord\Rulesets;
use FacebookAds\Api;
use FacebookAds\Http\RequestInterface;
use FacebookAds\Object\LeadgenForm;
use Yii;
use yii\console\Controller;
use yii\console\Exception;

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

            $connections = Connections::find()->where( [ 'check_interval' => $interval, 'is_active' => true ] )->all();
            foreach ( $connections as $connection )
            {
                $this->log( "Found connection with id = $connection->id" );
                $connection->last_time_checked = Yii::$app->formatter->asDatetime( time(), FORMATTER_MYSQL_DATETIME_FORMAT );
                $connection->save();

                $ruleset = Rulesets::findOne( [ 'id' => $connection->ruleset_id ] );
                if ( !$ruleset )
                    throw new Exception( "Can't find ruleset with id $connection->ruleset_id for connection $connection->id" );

                $formFields = Api::instance()->call( "/$ruleset->leadform_id", RequestInterface::METHOD_GET, [ 'fields' => 'id,name,qualifiers' ] )->getContent();
                $fieldsHelper = new Leadfieldshelper( $formFields['qualifiers'], $ruleset->fieldConnections );

                $leads = ( new LeadgenForm( $ruleset->leadform_id ) )->getLeads();
                if ( !$leads->count() )
                {
                    $this->log( "Form $ruleset->leadform_id have no leads. Continue..." );
                    continue;
                }

                if ( \DateTime::createFromFormat( \DateTime::W3C, $leads->current()->getData()['created_time'] )->getTimestamp() <= Yii::$app->formatter->asTimestamp( $connection->last_lead_time ) )
                {
                    $this->log( "Form $ruleset->leadform_id have no new leads. Continue..." );
                    continue;
                }

                /** @var \FacebookAds\Object\Lead $lead */
                $leadsSendedCounter = 0;
                foreach ( $leads as $lead )
                {
                    $lead = $lead->getData();
                    $adfData = $fieldsHelper->getAdfFieldsByLead( $lead['field_data'] );
                    if ( empty( $adfData ) )
                        continue;

                    $xmlString = $generator->generateADF( $adfData );

                    //TODO: more options in connection
                    \Yii::$app->mailer->compose()
                        ->setFrom( [ 'admin@clcdatahub.com' => 'Facebook leads sender' ] )
                        ->setTo( $connection->email )
                        ->setSubject( "Test subject" )
                        ->setTextBody( $xmlString )
                        ->send();

                    $leadCreatedTime = \DateTime::createFromFormat( \DateTime::W3C, $lead['created_time'] );

                    if ( $leadCreatedTime->getTimestamp() > (int) Yii::$app->formatter->asTimestamp( $connection->last_lead_time ) )
                    {
                        $connection->last_lead_time = $leadCreatedTime->format( MYSQL_DATETIME_FORMAT );
                    }

                    $leadsSendedCounter++;
                }

                $connection->save();

                $this->log( "Sended $leadsSendedCounter leads to $connection->email." );
            }
        }

        $this->log( "Done." );
    }

    private function log( $message, $eol = true )
    {
        if ( !$this->debug )
            return;

        echo $message . ( $eol ? PHP_EOL : '' );
    }
}