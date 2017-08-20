<?php

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Connections */
/* @var array $clientsDropdownItems */
/* @var array $destinationsDropdownItems */
/* @var array $rulesetsDropdownItems */

$this->title = 'Update Connection: ' . $model->name;
$this->params['breadcrumbs'][] = [ 'label' => 'Connections', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->name, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="connections-update">

    <?= $this->render( '_form', [
        'model'                     => $model,
        'clientsDropdownItems'      => $clientsDropdownItems,
        'destinationsDropdownItems' => $destinationsDropdownItems,
        'rulesetsDropdownItems'     => $rulesetsDropdownItems,
    ] ) ?>

</div>
