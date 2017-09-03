<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register( $this );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode( $this->title ) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin( [
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ] );
    echo Nav::widget( [
        'options' => [ 'class' => 'navbar-nav' ],
        'items'   => [
            [ 'label' => 'Home', 'url' => [ '/site/index' ] ],
            [ 'label' => 'Connections', 'url' => [ '/connections/index' ] ],
            [ 'label' => 'Destinations', 'url' => [ '/destinations/index' ] ],
            [ 'label' => 'Rulesets', 'url' => [ '/rulesets/index' ] ],
        ],
    ] );
    echo Nav::widget( [
        'options' => [ 'class' => 'navbar-nav navbar-right' ],
        'items'   => [
            [ 'label' => 'Reset', 'url' => [ '/site/reset' ], 'options' => [ 'title' => 'Reset Facebook session' ] ],
            Yii::$app->user->isGuest ? (
            [ 'label' => 'Login', 'url' => [ '/site/login' ] ]
            ) : (
                '<li>'
                . Html::beginForm( [ '/site/logout' ], 'post' )
                . Html::submitButton(
                    'Logout',
                    [ 'class' => 'btn btn-link logout' ]
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ] );
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget( [
            'links' => isset( $this->params['breadcrumbs'] ) ? $this->params['breadcrumbs'] : [],
        ] ) ?>
        <div class="page-content">
            <?php if ( $this->title != 'Not Found (#404)' ): ?>
                <h1><?= $this->title ?></h1>
            <?php endif; ?>
            <?php if ( isset( Yii::$app->params['warning'] ) ): ?>
                <div class="bg-warning paragraph">
                    <?= Yii::$app->params['warning'] ?>
                </div>
            <?php endif; ?>
            <?php if ( isset( Yii::$app->params['message'] ) ): ?>
                <div class="bg-success paragraph">
                    <?= Yii::$app->params['message'] ?>
                </div>
            <?php endif; ?>
            <?php if ( isset( Yii::$app->params['error'] ) ): ?>
                <div class="bg-danger paragraph">
                    <?= Yii::$app->params['error'] ?>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Facebook Leads Sender <?= date( 'Y' ) ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
