<?php

/* @var $this yii\web\View */
/* @var $model app\models\activerecord\Clients */

$this->title = 'Update Clients: ' . $model->name;
$this->params['breadcrumbs'][] = [ 'label' => 'Clients', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->name, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clients-update">

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
