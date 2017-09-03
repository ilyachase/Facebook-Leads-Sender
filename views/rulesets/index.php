<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\Activerecord\RulesetsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rulesets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rulesets-index">

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'facebookPageLink',
                'format' => 'raw',
                'label' => 'Page Url',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
