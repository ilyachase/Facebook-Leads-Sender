<?php

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Connections */
/* @var array $clientsDropdownItems */
/* @var array $destinationsDropdownItems */
/* @var array $rulesetsDropdownItems */

$this->title = 'Create Connections';
$this->params['breadcrumbs'][] = [ 'label' => 'Connections', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="connections-create">

    <?= $this->render( '_form', [
        'model'                     => $model,
        'clientsDropdownItems'      => $clientsDropdownItems,
        'destinationsDropdownItems' => $destinationsDropdownItems,
        'rulesetsDropdownItems'     => $rulesetsDropdownItems,
    ] ) ?>

</div>
