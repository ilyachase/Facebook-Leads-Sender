<?php

/* @var $this yii\web\View */

$this->title = 'Ad Accounts';
?>
<div class="page-content">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
            </tr>
        </thead>
        <tbody>
            <?php /** @var \app\models\Adaccount $adaccount */
            foreach ($adaccounts as $adaccount): ?>
                <tr>
                    <td><?= $adaccount->id ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
