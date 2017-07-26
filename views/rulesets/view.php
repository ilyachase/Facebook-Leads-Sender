<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\activerecord\Rulesets */

$this->title = $model->id;
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
            'id',
            'leadform_id',
        ],
    ] ) ?>

    <h2>Field connections</h2>
    <table class="table table-bordered">
        <tr>
            <th>Leadgen form field</th>
            <th>ADF field</th>
        </tr>
        <?php foreach ( $model->fieldConnections as $connection ): ?>
            <tr>
                <td><?= $connection->leadgenFieldQuestion ?></td>
                <td><?= \app\models\ADFGenerator::GetSingleFieldText( $connection->ADFfieldId ) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
