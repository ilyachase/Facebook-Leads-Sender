<?php

use app\models\Activerecord\Clients;
use app\models\Activerecord\Destinations;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Connections */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [ 'label' => 'Connections', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="connections-view">

    <p>
        <?= Html::a( 'Update', [ 'update', 'id' => $model->id ], [ 'class' => 'btn btn-primary' ] ) ?>
        <?= Html::a( 'Delete', [ 'delete', 'id' => $model->id ], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ] ) ?>
    </p>

    <?= DetailView::widget( [
        'model'      => $model,
        'attributes' => [
            'id',
            'ruleset_id',
            [
                'label' => 'Client', 'value' => function ( $model ) {
                /** @var \app\models\Activerecord\Connections $model */
                return Clients::findOne( $model->client_id )->name;
            }
            ],
            [
                'label' => 'check_interval',
                'value' => function ( $model ) {
                    /** @var \app\models\Activerecord\Connections $model */
                    return Yii::$app->params[PARAMS_CONNECTIONS_CHECK_INTERVALS][$model->check_interval];
                }
            ],
            [
                'label' => 'Destination', 'value' => function ( $model ) {
                /** @var \app\models\Activerecord\Connections $model */
                return Destinations::findOne( $model->destination_id )->name;
            }
            ],
            'last_time_checked',
            'last_lead_time',
            'is_active',
        ],
    ] ) ?>

</div>
