<?php

namespace app\controllers;

use app\models\FbToken;
use FacebookAds\Api;
use Yii;
use yii\web\Controller;

class Basecontroller extends Controller
{
    /** @var string */
    protected $_userId;

    /** @var FbToken */
    protected $_fbToken;

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws \Exception
     */
    public function beforeAction( $action )
    {
        if ( !parent::beforeAction( $action ) )
            return false;

        if ( Yii::$app->requestedAction->id === 'login' )
        {
            return true;
        }

        $this->_fbToken = new FbToken();

        if ( !( $token = $this->_fbToken->getToken() ) && Yii::$app->request->getUrl() != '/' && false === strpos( Yii::$app->request->getUrl(), 'code' ) )
        {
            Yii::$app->session['back_url'] = Yii::$app->request->getUrl();
            $this->redirect( '/' );
            return false;
        }

        Api::init(
            Yii::$app->params[PARAMS_FB_APP_ID],
            Yii::$app->params[PARAMS_FB_APP_SECRET],
            $token
        );

        try
        {
            $this->_userId = Api::instance()->call( '/me', 'GET' )->getContent()['id'];
            if ( !$this->_userId )
                throw new \Exception( "Can't get user id" );
        }
        catch ( \FacebookAds\Http\Exception\AuthorizationException $e )
        {
            if ( Yii::$app->request->getUrl() != '/' && false === strpos( Yii::$app->request->getUrl(), 'code' ) )
            {
                Yii::$app->session['back_url'] = Yii::$app->request->getUrl();
                $this->redirect( '/' );
                return false;
            }
        }
        catch ( \Exception $e )
        {
            throw $e;
        }

        return true;
    }
}