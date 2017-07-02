<?php
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Businesses';
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>Name</th>
        <th>ID</th>
    </tr>
    </thead>
    <tbody>
    <?php /** @var \app\models\ScalarBusiness $business */
    foreach ( $businesses as $business ): ?>
        <tr>
            <td>
                <a href="<?= Url::to( [ 'site/adaccount', 'id' => $business->id ] ) ?>">
                    <?= $business->name ?>
                </a>
            </td>
            <td>
                <?= $business->id ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>