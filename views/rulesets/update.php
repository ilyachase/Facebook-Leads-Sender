<?php

/**
 * @var $this yii\web\View
 * @var ADFGenerator $adfGenerator
 */

use app\models\ADFGenerator;
use yii\widgets\ActiveForm;

/* @var $model app\models\Activerecord\Rulesets */

$this->title = 'Update Rulesets: ' . $model->id;
$this->params['breadcrumbs'][] = [ 'label' => 'Rulesets', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->id, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';

?>
<?php $form = ActiveForm::begin(); ?>

    <h3>Ruleset updating form</h3>
    <hr/>

    <div class="row">
        <?= $form->field( $model, 'name', [ 'options' => [ 'class' => 'col-sm-6 col-sm-offset-2' ] ] )->textInput() ?>
    </div>

    <div class="row">
        <p class="text-info text-center">
            <strong>Info:</strong> To include question text in ADF field, use according checkboxes near selects lists.
        </p>
    </div>

    <div class="row">
        <div class="col-sm-4 col-sm-offset-1 text-center"><h4>Leadgen form fields</h4></div>
        <div class="col-sm-4 text-center"><h4>ADF fields</h4></div>
    </div>

<?php foreach ( $model->fieldConnections as $field ): ?>
    <div class="col-sm-4 col-sm-offset-1">
        <p class="form-control-static">
            <?= $field->leadgenFieldQuestion ?>
        </p>
        <input type="hidden" name="fieldConnections[<?= $field->leadgenFieldId ?>][<?= \app\models\Scalar\ScalarFieldConnection::KEY_QUESTION ?>]" value="<?= $field->leadgenFieldQuestion ?>">
    </div>
    <div class="form-group clearfix">
        <div class="col-sm-4">
            <select class="form-control" name="fieldConnections[<?= $field->leadgenFieldId ?>][<?= \app\models\Scalar\ScalarFieldConnection::KEY_ADF_FIELD_ID ?>]">
                <?= $adfGenerator->getADFFieldSelectOptionsHtml( $field->ADFfieldId ) ?>
            </select>
            <input class="ml5 ruleset-question-checkbox" title="Include question text in ADF field"<?= ( $field->includeQuestion ? ' checked="checked"' : '' ) ?> name="fieldConnections[<?= $field->leadgenFieldId ?>][<?= \app\models\Scalar\ScalarFieldConnection::KEY_INCLUDE_QUESTION ?>]" type="checkbox" value="1">
        </div>
    </div>
<?php endforeach; ?>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-1">
            <button class="btn btn-success pull-right">Submit</button>
        </div>
    </div>

<?php ActiveForm::end(); ?>