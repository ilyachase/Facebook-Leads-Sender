<?php

/* @var $this yii\web\View */

$this->title = 'Ad Account "' . $id . '"';
?>

    <h2>Leadgen Forms</h2>
<?php
/** @var \app\models\ScalarLeadForm $leadForm */
foreach ( $leadForms as $leadForm ):
    ?>
    <dl class="dl-horizontal">
        <dt>Name</dt>
        <dd><?= $leadForm->name . "($leadForm->id)" ?></dd>
        <dt>Leads export url</dt>
        <dd>
            <a href="<?= $leadForm->exportUrl ?>">
                <?= $leadForm->exportUrl ?>
            </a>
        </dd>
        <dt>Status</dt>
        <dd><?= $leadForm->status ?></dd>
    </dl>
<?php endforeach; ?>