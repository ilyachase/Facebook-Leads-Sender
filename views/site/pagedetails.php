<?php

/**
 * @var $this yii\web\View
 * @var array $leadForms
 */

use yii\helpers\Url;

$this->title = 'Page "' . $name . '"';
?>

    <h2>Leadgen Forms</h2>
<?php
/** @var \app\models\Scalar\ScalarLeadForm $leadForm */
foreach ( $leadForms as $leadForm ):
    ?>
    <dl class="dl-horizontal">
        <dt>Name</dt>
        <dd><?= $leadForm->name . " ($leadForm->id)" ?></dd>
        <dt>Leads export url</dt>
        <dd>
            <a href="<?= $leadForm->exportUrl ?>">
                <?= $leadForm->exportUrl ?>
            </a>
        </dd>
        <dt>Status</dt>
        <dd><?= $leadForm->status ?></dd>
        <dt></dt>
        <dd>
            <a class="btn btn-primary" href="<?= Url::to( [ 'rulesets/create', 'id' => $leadForm->id ] ) ?>">
                <i class="fa fa-pencil-square-o"></i> Create ADF ruleset
            </a>
        </dd>
    </dl>
<?php endforeach; ?>