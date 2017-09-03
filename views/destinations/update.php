<?php

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Destinations */

$this->title = 'Update Destination: ' . $model->name;
$this->params['breadcrumbs'][] = [ 'label' => 'Destinations', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->name, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destinations-update">

    <?= $this->render( '_form', [
        'model'                     => $model,
        'destinationsDropdownItems' => [],
        'ruleset_id'                => null,
    ] ) ?>

</div>
