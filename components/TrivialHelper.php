<?php

namespace app\components;

use Yii;
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

    /**
     * @param string $text
     */
    public static function AddWarning( $text )
    {
        self::AddMessage( $text, 'warning' );
    }

    /**
     * @param string $text
     * @param string $key
     */
    public static function AddMessage( $text, $key = 'message' )
    {
        if ( ( !isset( Yii::$app->params[$key] ) ) || ( !Yii::$app->params[$key] ) )
        {
            Yii::$app->params[$key] = $text;
        }
        else
        {
            Yii::$app->params[$key] .= PHP_EOL . $text;
        }
    }

    /**
     * @param string $text
     */
    public static function AddError( $text )
    {
        self::AddMessage( $text, 'error' );
    }
}