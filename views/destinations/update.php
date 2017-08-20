<?php

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Destinations */
/* @var array $clientsDropdownItems */

$this->title = 'Update Destination: ' . $model->name;
$this->params['breadcrumbs'][] = [ 'label' => 'Destinations', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->name, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destinations-update">

    <?= $this->render( '_form', [
        'model'                     => $model,
        'clientsDropdownItems'      => $clientsDropdownItems,
        'destinationsDropdownItems' => [],
        'ruleset_id'                => null,
    ] ) ?>

</div>
