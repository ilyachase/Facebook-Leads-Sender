<?php

/* @var $this yii\web\View */

use app\models\ADFGenerator;

/* @var $model app\models\activerecord\Rulesets */

$this->title = 'Update Rulesets: ' . $model->id;
$this->params['breadcrumbs'][] = [ 'label' => 'Rulesets', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->id, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';
$adfGenerator = new ADFGenerator();

?>
<h3>Ruleset updating form</h3>
<hr/>
<div class="row">
    <div class="col-sm-4 col-sm-offset-1 text-center"><h4>Leadgen form fields</h4></div>
    <div class="col-sm-4 text-center"><h4>ADF fields</h4></div>
</div>
<form class="form-horizontal" method="post">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
    <?php foreach ( $model->fieldConnections as $field ): ?>
        <div class="col-sm-4 col-sm-offset-1">
            <p class="form-control-static"><?= $field->leadgenFieldQuestion ?></p>
            <input type="hidden" name="fieldConnections[<?= $field->leadgenFieldId ?>][<?= \app\models\scalar\ScalarFieldConnection::KEY_QUESTION ?>]" value="<?= $field->leadgenFieldQuestion ?>">
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <select class="form-control" name="fieldConnections[<?= $field->leadgenFieldId ?>][<?= \app\models\scalar\ScalarFieldConnection::KEY_ADF_FIELD_ID ?>]">
                    <?= $adfGenerator->getADFFieldSelectOptionsHtml( $field->ADFfieldId ) ?>
                </select>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-1">
            <button class="btn btn-success pull-right">Submit</button>
        </div>
    </div>
</form>