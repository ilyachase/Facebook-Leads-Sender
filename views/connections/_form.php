<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\activerecord\Connections */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="connections-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'ruleset_id' )->textInput() ?>

    <?= $form->field( $model, 'client_id' )->textInput() ?>

    <?= $form->field( $model, 'check_interval' )->dropDownList( Yii::$app->params[PARAMS_CONNECTIONS_CHECK_INTERVALS] ) ?>

    <?= $form->field( $model, 'email' )->textInput() ?>

    <?= $form->field( $model, 'is_active' )->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
