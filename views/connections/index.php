<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ConnectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Connections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="connections-index">

    <p>
        <?= Html::a('Create Connection', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ruleset_id',
            'client_id',
            'check_interval',
            'last_time_checked',
            // 'is_active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
