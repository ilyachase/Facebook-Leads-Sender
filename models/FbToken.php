<?php

namespace app\models;

use Yii;

class FbToken
{
    /** @var string */
    private $_tokenFilePath;

    public function __construct()
    {
        $this->_tokenFilePath = Yii::getAlias( '@runtime' ) . DS . 'fb_token.json';
    }

    /**
     * @return string|null
     */
    public function getToken()
    {
        $result = null;

        if ( file_exists( $this->_tokenFilePath ) )
        {
            $result = json_decode( file_get_contents( $this->_tokenFilePath ) );
        }

        return $result;
    }

    /**
     * @param string $token
     */
    public function setToken( $token )
    {
        file_put_contents( $this->_tokenFilePath, json_encode( $token ) );
    }

    public function removeToken()
    {
        unlink( $this->_tokenFilePath );
    }
}