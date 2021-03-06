<?php

namespace app\controllers;

use app\components\TrivialHelper;
use Yii;
use app\models\Activerecord\Destinations;
use app\models\Activerecord\DestinationsSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DestinationsController implements the CRUD actions for Destinations model.
 */
class DestinationsController extends Controller
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
     * Lists all Destinations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DestinationsSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render( 'index', [
            'searchModel'          => $searchModel,
            'dataProvider'         => $dataProvider,
        ] );
    }

    /**
     * Displays a single Destinations model.
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
     * Creates a new Destinations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param null|int $ruleset_id
     *
     * @return mixed
     */
    public function actionCreate( $ruleset_id = null )
    {
        $model = new Destinations();

        if ( $model->load( Yii::$app->request->post() ) && $model->save() )
        {
            if ( $ruleset_id )
            {
                return $this->redirect( [ 'connections/create', 'ruleset_id' => $ruleset_id, 'destination_id' => $model->id ] );
            }

            return $this->redirect( [ 'view', 'id' => $model->id ] );
        }
        else
        {
            return $this->render( 'create', [
                'ruleset_id'                => $ruleset_id,
                'model'                     => $model,
                'destinationsDropdownItems' => $ruleset_id ? ArrayHelper::map( Destinations::find()->all(), 'id', 'name' ) : [],
            ] );
        }
    }

    /**
     * @param int $id
     *
     * @return string|\yii\web\Response
     */
    public function actionDuplicate( $id )
    {
        $model = $this->findModel( $id );
        $model->id = null;
        $model->setIsNewRecord( true );

        if ( $model->load( Yii::$app->request->post() ) && $model->save() )
        {
            return $this->redirect( [ 'view', 'id' => $model->id ] );
        }
        else
        {
            return $this->render( 'create', [
                'model'                     => $model,
                'ruleset_id'                => null,
                'destinationsDropdownItems' => [],
            ] );
        }
    }

    /**
     * Updates an existing Destinations model.
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
                'model'                => $model,
            ] );
        }
    }

    /**
     * Deletes an existing Destinations model.
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
     * Finds the Destinations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Destinations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel( $id )
    {
        if ( ( $model = Destinations::findOne( $id ) ) !== null )
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException( 'The requested page does not exist.' );
        }
    }
}
