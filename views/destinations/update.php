<?php

/* @var $this yii\web\View */
/* @var $model app\models\activerecord\Destinations */

$this->title = 'Update Destinations: ' . $model->name;
$this->params['breadcrumbs'][] = [ 'label' => 'Destinations', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->name, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destinations-update">

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
