<?php

/* @var $this yii\web\View */
/* @var $model app\models\activerecord\Connections */
/* @var array $clientsDropdownItems */
/* @var array $destinationsDropdownItems */

$this->title = 'Update Connections: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Connections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="connections-update">

    <?= $this->render('_form', [
        'model' => $model,
        'clientsDropdownItems'      => $clientsDropdownItems,
        'destinationsDropdownItems' => $destinationsDropdownItems,
    ]) ?>

</div>
