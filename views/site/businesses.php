<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/** @var \app\models\Scalar\ScalarBusiness[] $businesses */

$this->title = 'Businesses';
$this->params['breadcrumbs'][] = $this->title;
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>Name</th>
        <th>ID</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ( $businesses as $business ): ?>
        <tr>
            <td>
                <a href="<?= Url::to( [ 'site/businessdetails', 'id' => $business->id ] ) ?>">
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