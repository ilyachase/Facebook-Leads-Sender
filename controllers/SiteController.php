<?php

namespace app\controllers;

use app\models\ADFGenerator;
use app\models\Rulesets;
use app\models\ScalarLeadForm;
use app\models\ScalarLeadgenForm;
use app\models\ScalarPage;
use FacebookAds\Api;
use FacebookAds\Http\RequestInterface;
use FacebookAds\Object\Page;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ScalarBusiness;
use Facebook\Facebook;

class SiteController extends Controller
{
    /** @var Facebook */
    private $_fbApi;

    /** @var string */
    private $_userId;

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
        parent::init();

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
    }

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

        if ( !isset( Yii::$app->session['facebook_access_token'] ) && Yii::$app->request->getUrl() != '/' && false === strpos( Yii::$app->request->getUrl(), 'code' ) )
        {
            Yii::$app->session['back_url'] = Yii::$app->request->getUrl();
            $this->redirect( '/' );
            return false;
        }

        try
        {
            $this->_userId = Api::instance()->call( '/me', 'GET' )->getContent()['id'];
            if ( !$this->_userId )
                throw new \Exception( "Can't get user id" );
        }
        catch ( \FacebookAds\Http\Exception\AuthorizationException $e )
        {
            // TODO: try to prolong access token
            unset( Yii::$app->session['facebook_access_token'] );
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
                $loginUrl = $helper->getLoginUrl( Yii::$app->getRequest()->absoluteUrl, Yii::$app->params[PARAMS_FB_SCOPES] );
                Yii::$app->params['warning'] = 'In order to work with the system, you should <a href="' . $loginUrl . '">log in with Facebook</a> first.';
                return $this->render( 'fb_login' );
            }
        }

        if ( isset( Yii::$app->session['back_url'] ) )
        {
            $redirectUrl = Yii::$app->session['back_url'];
            unset( Yii::$app->session['back_url'] );
            return $this->redirect( $redirectUrl );
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
        Yii::$app->session->destroy();

        return $this->goHome();
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionBusinessdetails( $id )
    {
        $businessName = Api::instance()->call( "/940459386005248", 'GET' )->getContent()['name'];

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

    /**
     * @param $id
     *
     * @return string
     */
    public function actionCreateruleset( $id )
    {
        $formData = Api::instance()->call( "/$id", RequestInterface::METHOD_GET, [ 'fields' => 'id,name,qualifiers' ] )->getContent();
        $leadgenForm = new ScalarLeadgenForm( $formData );

        if ( Yii::$app->request->isPost )
        {
            ( new Rulesets() )->fillFromPost( $id, Yii::$app->request->post() )->save();
            Yii::$app->params['message'] = 'Ruleset saved successfull.';
        }

        return $this->render( 'createruleset', [ 'leadgenForm' => $leadgenForm, 'selectOptions' => ( new ADFGenerator() )->getADFFieldSelectOptionsHtml() ] );
    }
}
