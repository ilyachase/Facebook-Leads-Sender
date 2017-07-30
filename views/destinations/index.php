<?php

use app\components\TrivialHelper;
use app\models\activerecord\Clients;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\activerecord\DestinationsSearch */
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
                    /** @var \app\models\activerecord\Destinations $data */
                    return Clients::findOne( $data->client_id )->name;
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
