<?php

use app\components\TrivialHelper;
use app\models\Activerecord\Clients;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Activerecord\DestinationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var array $clientsDropdownItems */

$this->title = 'Destinations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinations-index">

    <p>
        <?= Html::a( 'Create Destinations', [ 'create' ], [ 'class' => 'btn btn-success' ] ) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [ 'class' => 'yii\grid\SerialColumn' ],

            'id',
            'name',
            'client_id' => [
                'attribute' => 'client_id',
                'label'    => 'Client',
                'class'     => 'yii\grid\DataColumn',
                'value'     => function ( $data ) {
                    /** @var \app\models\Activerecord\Destinations $data */
                    return $data->client_id !== null ? Clients::findOne( $data->client_id )->name : null;
                },
                'filter'    => $clientsDropdownItems,
            ],
            'content_type',
            'email_to:email',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {duplicate}',
                'buttons'  => [
                    'duplicate' => TrivialHelper::DuplicateButton(),
                ],
            ],
        ],
    ] ); ?>
    <?php Pjax::end(); ?></div>
