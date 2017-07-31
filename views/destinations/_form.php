<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Destinations */
/* @var $form yii\widgets\ActiveForm */
/* @var array $clientsDropdownItems */
?>

<div class="destinations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'name' )->textInput() ?>

    <?= $form->field( $model, 'client_id' )->dropDownList( $clientsDropdownItems ) ?>

    <?= $form->field( $model, 'email_from' )->textInput() ?>

    <?= $form->field( $model, 'email_to' )->textInput() ?>

    <?= $form->field( $model, 'cc' )->textInput() ?>

    <?= $form->field( $model, 'bcc' )->textInput() ?>

    <?= $form->field( $model, 'subject' )->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
