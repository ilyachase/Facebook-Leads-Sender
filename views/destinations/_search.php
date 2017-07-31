<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\DestinationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destinations-search">

    <?php $form = ActiveForm::begin( [
        'action' => [ 'index' ],
        'method' => 'get',
    ] ); ?>

    <?= $form->field( $model, 'id' ) ?>

    <?= $form->field( $model, 'name' ) ?>

    <?= $form->field( $model, 'client_id' ) ?>

    <?= $form->field( $model, 'content_type' ) ?>

    <?= $form->field( $model, 'email_to' ) ?>

    <?php // echo $form->field($model, 'cc') ?>

    <?php // echo $form->field($model, 'bcc') ?>

    <?php // echo $form->field($model, 'subject') ?>

    <div class="form-group">
        <?= Html::submitButton( 'Search', [ 'class' => 'btn btn-primary' ] ) ?>
        <?= Html::resetButton( 'Reset', [ 'class' => 'btn btn-default' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
