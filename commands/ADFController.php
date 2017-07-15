<?php

namespace app\commands;

use app\models\Connections;
use app\models\FbToken;
use app\models\Rulesets;
use FacebookAds\Api;
use FacebookAds\Object\LeadgenForm;
use Yii;
use yii\console\Controller;
use yii\console\Exception;

class AdfController extends Controller
{
    /** @var bool */
    public $debug = false;

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

        foreach ( Yii::$app->params[PARAMS_CONNECTIONS_CHECK_INTERVALS] as $interval => $label )
        {
            if ( $currentMinutes % $interval )
                continue;

            $connections = Connections::find()->where( [ 'check_interval' => $interval, 'is_active' => true ] )->all();
            foreach ( $connections as $connection )
            {
                $ruleset = Rulesets::findOne( [ 'id' => $connection->ruleset_id ] );
                if ( !$ruleset )
                    throw new Exception( "Can't find ruleset with id $connection->ruleset_id for connection $connection->id" );

                $form = new LeadgenForm( $ruleset->leadform_id );
            }
        }
    }

    private function log( $message, $eol = true )
    {
        if ( !$this->debug )
            return;

        echo $message . $eol ? PHP_EOL : '';
    }
}