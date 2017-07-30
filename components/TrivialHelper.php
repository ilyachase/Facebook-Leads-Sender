<?php

namespace app\components;

use yii\helpers\Html;

class TrivialHelper
{
    /**
     * @return \Closure
     */
    public static function DuplicateButton()
    {
        return function ( $url ) {
            return Html::a( '<span" class="glyphicon glyphicon-duplicate"></span>', $url, [ 'title' => 'Duplicate' ] );
        };
    }
}