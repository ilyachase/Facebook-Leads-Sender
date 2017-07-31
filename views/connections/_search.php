<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\ConnectionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="connections-search">

    <?php $form = ActiveForm::begin( [
        'action' => [ 'index' ],
        'method' => 'get',
    ] ); ?>

    <?= $form->field( $model, 'client_id' ) ?>

    <?= $form->field( $model, 'is_active' ) ?>

    <div class="form-group">
        <?= Html::submitButton( 'Search', [ 'class' => 'btn btn-primary' ] ) ?>
        <?= Html::resetButton( 'Reset', [ 'class' => 'btn btn-default' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
