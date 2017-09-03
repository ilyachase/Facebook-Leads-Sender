<?php

use app\components\TrivialHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Activerecord\DestinationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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

            'subject',
            'name',
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
