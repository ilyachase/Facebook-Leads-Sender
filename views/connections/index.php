<?php

use app\models\Activerecord\Destinations;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Activerecord\ConnectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var array $destinationsDropdownItems */

$this->title = 'Connections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="connections-index">

    <p>
        <?= Html::a( 'Create Connection', [ 'create' ], [ 'class' => 'btn btn-success' ] ) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [ 'class' => 'yii\grid\SerialColumn' ],

            'name',
            [
                'attribute' => 'check_interval',
                'class'     => 'yii\grid\DataColumn',
                'value'     => function ( $data ) {
                    /** @var \app\models\Activerecord\Connections $data */
                    return Yii::$app->params[PARAMS_CONNECTIONS_CHECK_INTERVALS][$data->check_interval];
                },
                'filter'    => Yii::$app->params[PARAMS_CONNECTIONS_CHECK_INTERVALS],
            ],
            [
                'attribute' => 'destination_id',
                'label'     => 'Destination',
                'class'     => 'yii\grid\DataColumn',
                'value'     => function ( $data ) {
                    /** @var \app\models\Activerecord\Connections $data */
                    return Destinations::findOne( $data->destination_id )->name;
                },
                'filter'    => $destinationsDropdownItems,
            ],
            'is_active:boolean',
            'last_lead_time:datetime',

            [ 'class' => 'yii\grid\ActionColumn' ],
        ],
    ] ); ?>
    <?php Pjax::end(); ?></div>
