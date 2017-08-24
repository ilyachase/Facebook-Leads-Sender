<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activerecord\Rulesets */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [ 'label' => 'Rulesets', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rulesets-view">

    <p>
        <?= Html::a( 'Update', [ 'update', 'id' => $model->id ], [ 'class' => 'btn btn-primary' ] ) ?>
        <?= Html::a( 'Delete', [ 'delete', 'id' => $model->id ], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ] ) ?>
    </p>

    <?= DetailView::widget( [
        'model'      => $model,
        'attributes' => [
            'name',
            'leadform_id',
            [
                'label' => 'Page Url',
                'value' => $model->facebookPageLink,
                'format' => 'raw',
            ],
        ],
    ] ) ?>

    <h2>Field connections</h2>
    <table class="table table-bordered table-striped">
        <?php foreach ( $model->fieldConnections as $connection ): ?>
            <tr>
                <th><?= $connection->leadgenFieldQuestion ?></th>
                <td><?= \app\models\ADFGenerator::GetSingleFieldText( $connection->ADFfieldId ) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
