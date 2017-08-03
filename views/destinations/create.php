<?php

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Destinations */
/* @var array $clientsDropdownItems */
/* @var array $destinationsDropdownItems */
/* @var null|int $ruleset_id */

$this->title = $ruleset_id ? 'Create or choose destination' : 'Create destination';
$this->params['breadcrumbs'][] = [ 'label' => 'Destinations', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinations-create">

    <?= $this->render( '_form', [
        'ruleset_id'                => $ruleset_id,
        'model'                     => $model,
        'clientsDropdownItems'      => $clientsDropdownItems,
        'destinationsDropdownItems' => $destinationsDropdownItems,
    ] ) ?>

</div>
