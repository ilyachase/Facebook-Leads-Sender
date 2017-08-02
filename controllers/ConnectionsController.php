<?php

namespace app\controllers;

use app\models\Activerecord\Clients;
use app\models\Activerecord\Destinations;
use app\models\Activerecord\Rulesets;
use Yii;
use app\models\Activerecord\Connections;
use app\models\Activerecord\ConnectionsSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConnectionsController implements the CRUD actions for Connections model.
 */
class ConnectionsController extends Controller
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
     * Lists all Connections models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConnectionsSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render( 'index', [
            'searchModel'               => $searchModel,
            'dataProvider'              => $dataProvider,
            'clientsDropdownItems'      => ArrayHelper::map( Clients::find()->all(), 'id', 'name' ),
            'destinationsDropdownItems' => ArrayHelper::map( Destinations::find()->all(), 'id', 'name' ),
        ] );
    }

    /**
     * Displays a single Connections model.
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
     * Creates a new Connections model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Connections();
        $model->is_active = true;

        if ( $model->load( Yii::$app->request->post() ) && $model->save() )
        {
            return $this->redirect( [ 'view', 'id' => $model->id ] );
        }
        else
        {
            return $this->render( 'create', [
                'model'                     => $model,
                'clientsDropdownItems'      => ArrayHelper::map( Clients::find()->all(), 'id', 'name' ),
                'destinationsDropdownItems' => ArrayHelper::map( Destinations::find()->all(), 'id', 'name' ),
                'rulesetsDropdownItems'     => ArrayHelper::map( Rulesets::find()->all(), 'id', 'name' ),
            ] );
        }
    }

    /**
     * Updates an existing Connections model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate( $id )
    {
        $model = $this->findModel( $id );

        if ( $model->load( Yii::$app->request->post() ) && $model->save() )
        {
            return $this->redirect( [ 'view', 'id' => $model->id ] );
        }
        else
        {
            return $this->render( 'update', [
                'model'                     => $model,
                'clientsDropdownItems'      => ArrayHelper::map( Clients::find()->all(), 'id', 'name' ),
                'destinationsDropdownItems' => ArrayHelper::map( Destinations::find()->all(), 'id', 'name' ),
                'rulesetsDropdownItems'     => ArrayHelper::map( Rulesets::find()->all(), 'id', 'name' ),
            ] );
        }
    }

    /**
     * Deletes an existing Connections model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete( $id )
    {
        $this->findModel( $id )->delete();

        return $this->redirect( [ 'index' ] );
    }

    /**
     * Finds the Connections model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Connections the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel( $id )
    {
        if ( ( $model = Connections::findOne( $id ) ) !== null )
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException( 'The requested page does not exist.' );
        }
    }
}
