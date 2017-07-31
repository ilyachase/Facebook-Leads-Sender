<?php

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Clients */

$this->title = 'Create Clients';
$this->params['breadcrumbs'][] = [ 'label' => 'Clients', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
