<?php
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Ad Accounts';
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>ID</th>
    </tr>
    </thead>
    <tbody>
    <?php /** @var \app\models\ScalarAdaccount $adaccount */
    foreach ( $adaccounts as $adaccount ): ?>
        <tr>
            <td width="80%">
                <a href="<?= Url::to( [ 'site/adaccount', 'id' => $adaccount->id ] ) ?>">
                    <?= $adaccount->id ?>
                </a>
            </td>
            <td>
                <?php if ( $adaccount->haveForms ): ?>
                    <p class="text-success">Have leadgen forms</p>
                <?php else: ?>
                    <p class="text-warning">No leadgen forms</p>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>