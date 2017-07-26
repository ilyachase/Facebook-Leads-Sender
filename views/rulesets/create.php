<?php


/**
 * @var $this yii\web\View
 * @var $model app\models\activerecord\Rulesets
 * @var \app\models\scalar\ScalarLeadgenForm $leadgenForm
 * @var string $selectOptions
 */

$this->title = 'Create Rulesets';
$this->params['breadcrumbs'][] = ['label' => 'Rulesets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Url;

$this->title = 'Leadgen form "' . $leadgenForm->name . '"';
?>

<h3>Ruleset creating form</h3>
<p>
    To create a ruleset you should select ADF field (right coulmn) for each field from Leadgen form (left column) and then submit the form.
    <br/>After that you will able to use this ruleset at <a href="<?= Url::to( [ 'site/connections' ] ) ?>">connections page</a>.
</p>
<hr/>
<div class="row">
    <div class="col-sm-4 col-sm-offset-1 text-center"><h4>Leadgen form fields</h4></div>
    <div class="col-sm-4 text-center"><h4>ADF fields</h4></div>
</div>
<form class="form-horizontal" method="post">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
    <?php foreach ( $leadgenForm->fields as $field ): ?>
        <div class="col-sm-4 col-sm-offset-1">
            <p class="form-control-static"><?= $field->question ?></p>
            <input type="hidden" name="fieldConnections[<?= $field->id ?>][<?= \app\models\scalar\ScalarFieldConnection::KEY_QUESTION ?>]" value="<?= $field->question ?>">
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <select class="form-control" name="fieldConnections[<?= $field->id ?>][<?= \app\models\scalar\ScalarFieldConnection::KEY_ADF_FIELD_ID ?>]">
                    <?= $selectOptions ?>
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