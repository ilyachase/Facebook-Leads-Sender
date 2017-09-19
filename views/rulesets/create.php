<?php

/**
 * @var $this yii\web\View
 * @var $model app\models\Activerecord\Rulesets
 * @var \app\models\Scalar\ScalarLeadgenForm $leadgenForm
 * @var ADFGenerator $adfGenerator
 */

$this->title = 'Create Rulesets';
$this->params['breadcrumbs'][] = [ 'label' => 'Rulesets', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;

use app\models\ADFGenerator;
use yii\widgets\ActiveForm;

$this->title = 'Leadgen form "' . $leadgenForm->name . '"';
?>
<?php $form = ActiveForm::begin(); ?>

<?= $this->render( '/site/_progress', [ 'activeStep' => 1 ] ); ?>

    <h3>Ruleset creating form</h3>
    <p>
        To create a ruleset you should select ADF field (right coulmn) for each field from Leadgen form (left column) and then submit the form.
    </p>
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

<?php foreach ( $leadgenForm->fields as $field ): ?>
    <div class="col-sm-4 col-sm-offset-1">
        <p class="form-control-static">
            <?= $field->question ?>
        </p>
        <input type="hidden" name="fieldConnections[<?= $field->id ?>][<?= \app\models\Scalar\ScalarFieldConnection::KEY_QUESTION ?>]" value="<?= $field->question ?>">
    </div>
    <div class="form-group clearfix">
        <div class="col-sm-4">
            <select class="form-control" name="fieldConnections[<?= $field->id ?>][<?= \app\models\Scalar\ScalarFieldConnection::KEY_ADF_FIELD_ID ?>]">
                <?= $adfGenerator->getADFFieldSelectOptionsHtml( '', $field->question ) ?>
            </select>
            <input class="ml5 ruleset-question-checkbox" title="Include question text in ADF field" name="fieldConnections[<?= $field->id ?>][<?= \app\models\Scalar\ScalarFieldConnection::KEY_INCLUDE_QUESTION ?>]" type="checkbox" value="1">
        </div>
    </div>
<?php endforeach; ?>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-1">
            <button class="btn btn-success pull-right">Submit</button>
        </div>
    </div>

<?php ActiveForm::end(); ?>