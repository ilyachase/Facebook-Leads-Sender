<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Connections */
/* @var $form yii\widgets\ActiveForm */
/* @var array $clientsDropdownItems */
/* @var array $destinationsDropdownItems */
?>

<div class="connections-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'name' )->textInput() ?>

    <?= $form->field( $model, 'ruleset_id' )->textInput() ?>

    <?= $form->field( $model, 'client_id' )->dropDownList( $clientsDropdownItems ) ?>

    <?= $form->field( $model, 'check_interval' )->dropDownList( Yii::$app->params[PARAMS_CONNECTIONS_CHECK_INTERVALS] ) ?>

    <?= $form->field( $model, 'destination_id' )->dropDownList( $destinationsDropdownItems ) ?>

    <?= $form->field( $model, 'is_active' )->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
