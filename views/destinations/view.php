<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\activerecord\Destinations */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [ 'label' => 'Destinations', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinations-view">

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
            'name',
            'client_id',
            'content_type',
            'email_from:email',
            'email_to:email',
            'cc',
            'bcc',
            'subject',
        ],
    ] ) ?>

</div>