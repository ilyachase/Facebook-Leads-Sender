<?php

namespace app\controllers;

use Facebook\Authentication\AccessToken;
use FacebookAds\Api;
use FacebookAds\Object\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Adaccount;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => [ 'index', 'logout' ],
                'rules' => [
                    [
                        'actions' => [ 'index', 'logout' ],
                        'allow'   => true,
                        'roles'   => [ '@' ],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => [ 'post' ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if ( !Yii::$app->session->isActive )
        {
            Yii::$app->session->open();
        }

        $fb = new Facebook( [
            PARAMS_FB_APP_ID     => Yii::$app->params[PARAMS_FB_APP_ID],
            PARAMS_FB_APP_SECRET => Yii::$app->params[PARAMS_FB_APP_SECRET],
        ] );

        if ( !Yii::$app->session['facebook_access_token'] )
        {
            $helper = $fb->getRedirectLoginHelper();
            try
            {
                Yii::$app->session['facebook_access_token'] = (string) $helper->getAccessToken();
            }
            catch ( FacebookResponseException $e )
            {
                // TODO: When Graph returns an error
                //echo 'Graph returned an error: ' . $e->getMessage();
                //exit;
            }
            catch ( FacebookSDKException $e )
            {
                // TODO: When validation fails or other local issues
                //echo 'Facebook SDK returned an error: ' . $e->getMessage();
                //exit;
            }

            if ( !Yii::$app->session['facebook_access_token'] )
            {
                $loginUrl = $helper->getLoginUrl( Yii::$app->getRequest()->absoluteUrl, [ 'ads_management' ] );
                return $this->render( 'fb_login', [ 'loginUrl' => $loginUrl ] );
            }
        }

        Api::init(
            Yii::$app->params[PARAMS_FB_APP_ID],
            Yii::$app->params[PARAMS_FB_APP_SECRET],
            Yii::$app->session['facebook_access_token']
        );

        $adaccounts = [];
        /** @var \FacebookAds\Object\AdAccount $adaccount */
        foreach ( ( new User( 'me' ) )->getAdAccounts() as $adaccount )
        {
            $adaccounts[] = new Adaccount( $adaccount );
        }

        return $this->render( 'adaccounts', [ 'adaccounts' => $adaccounts ] );
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if ( !Yii::$app->user->isGuest )
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->login() )
        {
            return $this->goBack();
        }
        return $this->render( 'login', [
            'model' => $model,
        ] );
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render( 'about' );
    }
}
