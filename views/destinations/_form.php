<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Destinations */
/* @var $form yii\widgets\ActiveForm */
/* @var array $destinationsDropdownItems */
/* @var null|int $ruleset_id */
?>

<div class="destinations-form">

    <?= $ruleset_id ? $this->render( '/site/_progress', [ 'activeStep' => 2 ] ) : '' ?>

    <?php if ( $ruleset_id ): ?>
        <h2>Choose the destination</h2>

        <?= Html::beginForm( '/connections/create', 'GET' ) ?>

        <?= Html::hiddenInput( 'ruleset_id', $ruleset_id ) ?>

        <?= Html::csrfMetaTags() ?>

        <div class="form-group">
            <?= Html::dropDownList( 'destination_id', null, $destinationsDropdownItems, [ 'class' => 'form-control' ] ) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton( 'Choose', [ 'class' => 'btn btn-success' ] ) ?>
        </div>

        <?= Html::endForm(); ?>
        <hr/>
    <?php endif; ?>

    <?php if ( $ruleset_id ): ?>
        <h2>Or create new destination</h2>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'name' )->textInput() ?>

    <?= $form->field( $model, 'email_from' )->textInput() ?>

    <?= $form->field( $model, 'email_to' )->textInput() ?>

    <?= $form->field( $model, 'cc' )->textInput() ?>

    <?= $form->field( $model, 'bcc' )->textInput() ?>

    <?= $form->field( $model, 'subject' )->textInput() ?>

    <?= $form->field( $model, 'vendor_id' ) ?>

    <?= $form->field( $model, 'vendor_id_source' ) ?>

    <?= $form->field( $model, 'vendor_name' ) ?>

    <?= $form->field( $model, 'vendor_contact_name' ) ?>

    <?= $form->field( $model, 'provider_id' ) ?>

    <?= $form->field( $model, 'provider_id_source' ) ?>

    <?= $form->field( $model, 'provider_name' ) ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
