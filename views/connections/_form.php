<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Connections */
/* @var $form yii\widgets\ActiveForm */
/* @var array $destinationsDropdownItems */
/* @var array $rulesetsDropdownItems */
?>

<div class="connections-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= ( $model->ruleset_id && $model->isNewRecord ) ? $this->render( '/site/_progress', [ 'activeStep' => 3 ] ) : '' ?>

    <?= $form->field( $model, 'name' )->textInput() ?>

    <?= $form->field( $model, 'destination_id' )->dropDownList( $destinationsDropdownItems )->label( 'Destination' ) ?>

    <?= $form->field( $model, 'ruleset_id' )->dropDownList( $rulesetsDropdownItems )->label( 'Ruleset' ) ?>
    <?php if ( $model->ruleset_id ): ?>
        <span class="help-block">
        This is ruleset you created a moment ago.
    </span>
    <?php endif; ?>

    <?= $form->field( $model, 'check_interval' )->dropDownList( Yii::$app->params[PARAMS_CONNECTIONS_CHECK_INTERVALS] ) ?>

    <?= $form->field( $model, 'is_active' )->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
