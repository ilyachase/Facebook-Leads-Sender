<?php

namespace app\controllers;

use app\components\TrivialHelper;
use app\models\Scalar\ScalarLeadForm;
use app\models\Scalar\ScalarPage;
use FacebookAds\Api;
use FacebookAds\Object\Page;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Scalar\ScalarBusiness;
use Facebook\Facebook;

class SiteController extends Basecontroller
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

        if ( !$this->_fbToken->getToken() )
        {
            if ( !session_id() )
            {
                session_start();
            }

            $fbApi = new Facebook( [
                PARAMS_FB_APP_ID          => Yii::$app->params[PARAMS_FB_APP_ID],
                PARAMS_FB_APP_SECRET      => Yii::$app->params[PARAMS_FB_APP_SECRET],
                'persistent_data_handler' => 'session',
            ] );

            $helper = $fbApi->getRedirectLoginHelper();
            $token = (string) $helper->getAccessToken();

            if ( !$token )
            {
                $loginUrl = $helper->getLoginUrl( Yii::$app->getRequest()->absoluteUrl, Yii::$app->params[PARAMS_FB_SCOPES] );
                TrivialHelper::AddWarning( 'In order to work with the system, you should <a href="' . $loginUrl . '">log in with Facebook</a> first.' );
                return $this->render( 'fb_login' );
            }
            else
            {
                $token = (string) $fbApi->getOAuth2Client()->getLongLivedAccessToken( $token );
                $this->_fbToken->setToken( $token );

                if ( isset( Yii::$app->session['back_url'] ) )
                {
                    $redirectUrl = Yii::$app->session['back_url'];
                    unset( Yii::$app->session['back_url'] );
                    return $this->redirect( $redirectUrl );
                }

                return $this->goHome();
            }
        }

        $businesses = [];
        /** @var \FacebookAds\Object\AdAccount $adaccount */
        foreach ( Api::instance()->call( "/$this->_userId/businesses", 'GET' )->getContent()['data'] as $businessData )
        {
            $businesses[] = new ScalarBusiness( $businessData );
        }

        return $this->render( 'businesses', [ 'businesses' => $businesses ] );
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
     * Reset action.
     *
     * @return Response
     */
    public function actionReset()
    {
        $this->_fbToken->removeToken();

        return $this->goHome();
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionBusinessdetails( $id )
    {
        $businessName = Api::instance()->call( "/$id", 'GET' )->getContent()['name'];

        $pages = [];
        foreach ( Api::instance()->call( "/$id/pages", "GET" )->getContent()['data'] as $pageData )
        {
            $page = new Page( $pageData['id'] );
            $haveForms = false;
            try
            {
                $leadgen_forms = $page->getLeadgenForms();
                $haveForms = $leadgen_forms->count() > 0;
            }
            catch ( \FacebookAds\Http\Exception\AuthorizationException $e )
            {
            }

            $pages[] = new ScalarPage( $pageData, $haveForms );
        }

        return $this->render( 'businessdetails', [ 'name' => $businessName, 'pages' => $pages ] );
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionPagedetails( $id )
    {
        $page = new Page( $id );
        $pageName = $page->read()->getData()['name'];

        $leadForms = [];
        foreach ( $page->getLeadgenForms() as $leadgenForm )
        {
            $leadForms[] = new ScalarLeadForm( $leadgenForm->getData() );
        }

        return $this->render( 'pagedetails', [ 'name' => $pageName, 'leadForms' => $leadForms ] );
    }
}
