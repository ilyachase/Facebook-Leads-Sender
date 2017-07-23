<?php

/* @var $this yii\web\View */
/* @var $model app\models\activerecord\Destinations */

$this->title = 'Create Destinations';
$this->params['breadcrumbs'][] = [ 'label' => 'Destinations', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinations-create">

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
