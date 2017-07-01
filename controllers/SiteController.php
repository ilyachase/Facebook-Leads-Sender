<?php

namespace app\controllers;

use app\models\ScalarLeadForm;
use FacebookAds\Api;
use FacebookAds\Object\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ScalarAdaccount;
use Facebook\Facebook;

class SiteController extends Controller
{
    /** @var Facebook */
    private $_fbApi;

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

    public function init()
    {
        Api::init(
            Yii::$app->params[PARAMS_FB_APP_ID],
            Yii::$app->params[PARAMS_FB_APP_SECRET],
            Yii::$app->session['facebook_access_token']
        );

        $this->_fbApi = new Facebook( [
            PARAMS_FB_APP_ID          => Yii::$app->params[PARAMS_FB_APP_ID],
            PARAMS_FB_APP_SECRET      => Yii::$app->params[PARAMS_FB_APP_SECRET],
            'persistent_data_handler' => 'session',
        ] );

        parent::init();
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

        if ( !Yii::$app->session['facebook_access_token'] )
        {
            if ( !session_id() )
            {
                session_start();
            }

            $helper = $this->_fbApi->getRedirectLoginHelper();
            Yii::$app->session['facebook_access_token'] = (string) $helper->getAccessToken();

            if ( !Yii::$app->session['facebook_access_token'] )
            {
                $loginUrl = $helper->getLoginUrl( Yii::$app->getRequest()->absoluteUrl, [ 'ads_management', 'manage_pages' ] );
                return $this->render( 'fb_login', [ 'loginUrl' => $loginUrl ] );
            }
        }

        $adaccounts = [];
        /** @var \FacebookAds\Object\AdAccount $adaccount */
        foreach ( ( new User( 'me' ) )->getAdAccounts() as $adaccount )
        {
            $formsData = [];
            try
            {
                $formsData = Api::instance()->call( "/" . $adaccount->getData()['id'] . "/leadgen_forms", "GET" )->getContent()['data'];
            }
            catch ( \Exception $e )
            {
            }

            $adaccounts[] = new ScalarAdaccount( $adaccount, $formsData );
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
     * @param int $id
     *
     * @return string
     */
    public function actionAdaccount( $id )
    {
        $leadForms = [];
        foreach ( Api::instance()->call( "/$id/leadgen_forms", "GET" )->getContent()['data'] as $leadFormData )
        {
            $leadForms[] = new ScalarLeadForm( $leadFormData );
        }

        return $this->render( 'adaccount', [ 'id' => $id, 'leadForms' => $leadForms ] );
    }
}
