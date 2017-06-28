<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
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
                'only'  => [ 'logout' ],
                'rules' => [
                    [
                        'actions' => [ 'logout' ],
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
            'app_id'     => '109433556350716',
            'app_secret' => '22e9f275cbca86c39b8f51af404ae779',
        ] );

        $helper = $fb->getRedirectLoginHelper();

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
        }

        if ( !Yii::$app->session['facebook_access_token'] )
        {
            $loginUrl = $helper->getLoginUrl( Yii::$app->getRequest()->absoluteUrl, [ 'ads_management' ] );
            return $this->render( 'fb_login', ['loginUrl' => $loginUrl] );
        }

        return $this->render( 'index' );
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
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->contact( Yii::$app->params['adminEmail'] ) )
        {
            Yii::$app->session->setFlash( 'contactFormSubmitted' );

            return $this->refresh();
        }
        return $this->render( 'contact', [
            'model' => $model,
        ] );
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
