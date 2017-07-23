<?php

/* @var $this yii\web\View */
/* @var $model app\models\activerecord\Destinations */
/* @var array $clientsDropdownItems */

$this->title = 'Update Destinations: ' . $model->name;
$this->params['breadcrumbs'][] = [ 'label' => 'Destinations', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->name, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destinations-update">

    <?= $this->render( '_form', [
        'model' => $model,
        'clientsDropdownItems' => $clientsDropdownItems,
    ] ) ?>

</div>
