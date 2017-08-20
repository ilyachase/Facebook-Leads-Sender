<?php

namespace app\controllers;

use app\components\TrivialHelper;
use app\models\ADFGenerator;
use app\models\Scalar\ScalarLeadgenForm;
use FacebookAds\Api;
use FacebookAds\Http\RequestInterface;
use Yii;
use app\models\Activerecord\Rulesets;
use app\models\Activerecord\RulesetsSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RulesetsController implements the CRUD actions for Rulesets model.
 */
class RulesetsController extends Basecontroller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [ '@' ],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => [ 'POST' ],
                ],
            ],
        ];
    }

    /**
     * Lists all Rulesets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RulesetsSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render( 'index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ] );
    }

    /**
     * Displays a single Rulesets model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView( $id )
    {
        return $this->render( 'view', [
            'model' => $this->findModel( $id ),
        ] );
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function actionCreate( $id )
    {
        $formData = Api::instance()->call( "/$id", RequestInterface::METHOD_GET, [ 'fields' => 'id,name,qualifiers' ] )->getContent();
        $leadgenForm = new ScalarLeadgenForm( $formData );

        $model = new Rulesets();
        $model->name = "{$formData['name']} ({$formData['id']})";
        if ( Yii::$app->request->isPost )
        {
            $model->fillFromPost( $id, Yii::$app->request->post() )->save();
            return $this->redirect( [ 'destinations/create', 'ruleset_id' => $model->id ] );
        }

        return $this->render( 'create', [
            'model'         => $model,
            'leadgenForm'   => $leadgenForm,
            'selectOptions' => ( new ADFGenerator() )->getADFFieldSelectOptionsHtml(),
        ] );
    }

    /**
     * Updates an existing Rulesets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate( $id )
    {
        $model = $this->findModel( $id );

        if ( Yii::$app->request->isPost )
        {
            $model->fillFromPost( $model->leadform_id, Yii::$app->request->post() )->save();
            TrivialHelper::AddMessage( 'Ruleset updated successfull.' );
        }

        return $this->render( 'update', [
            'model' => $model,
        ] );
    }

    /**
     * Deletes an existing Rulesets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete( $id )
    {
        $model = $this->findModel( $id );
        if ( $message = $model->getDeletionErrorMessage() )
        {
            TrivialHelper::AddError( $message );
            return $this->actionIndex();
        }
        else
        {
            $model->delete();
        }

        return $this->redirect( [ 'index' ] );
    }

    /**
     * Finds the Rulesets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Rulesets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel( $id )
    {
        if ( ( $model = Rulesets::findOne( $id ) ) !== null )
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException( 'The requested page does not exist.' );
        }
    }
}
