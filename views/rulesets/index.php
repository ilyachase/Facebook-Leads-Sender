<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RulesetsSearch */
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

            'id',
            'leadform_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
