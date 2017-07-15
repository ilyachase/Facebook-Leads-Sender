<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Business "' . $name . '"';
?>

<h3>Pages</h3>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Name</th>
        <th>Category</th>
        <th>ID</th>
        <th>Have leadgen forms</th>
    </tr>
    </thead>
    <tbody>
    <?php /** @var \app\models\scalar\ScalarPage $page */
    foreach ( $pages as $page ): ?>
        <tr>
            <td>
                <a href="<?= Url::to( [ 'site/pagedetails', 'id' => $page->id ] ) ?>">
                    <?= $page->name ?>
                </a>
            </td>
            <td>
                <?= $page->category ?>
            </td>
            <td>
                <?= $page->id ?>
            </td>
            <td>
                <?php if ( $page->haveForms ): ?>
                    <p class="text-success">Have leadgen forms</p>
                <?php else: ?>
                    <p class="text-warning">No leadgen forms</p>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>