<?php

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Connections */
/* @var array $destinationsDropdownItems */
/* @var array $rulesetsDropdownItems */

$this->title = 'Create Connections';
$this->params['breadcrumbs'][] = [ 'label' => 'Connections', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="connections-create">

    <?= $this->render( '_form', [
        'model'                     => $model,
        'destinationsDropdownItems' => $destinationsDropdownItems,
        'rulesetsDropdownItems'     => $rulesetsDropdownItems,
    ] ) ?>

</div>
