<?php

namespace app\models;

class ADFGenerator
{
    /**
     * @var array
     */
    private $_ADFPartContact = [
        'name'    => true,
        'email'   => true,
        'phone'   => true,
        'address' => [
            'street'     => true,
            'apartment'  => true,
            'city'       => true,
            'regioncode' => true,
            'postalcode' => true,
            'country'    => true,
        ],
    ];

    /** @var array */
    private $_ADFFullStructure;

    public function __construct()
    {
        $this->_ADFFullStructure = [
            'customer' => [
                'contact'   => $this->_ADFPartContact,
                'id'        => true,
                'comments'  => true,
                'timeframe' => [
                    'description'  => true,
                    'earliestdate' => true,
                    'latestdate'   => true,
                ],
            ],
            'vehicle'  => [
                'id'               => true,
                'year'             => true,
                'make'             => true,
                'model'            => true,
                'vin'              => true,
                'stock'            => true,
                'trim'             => true,
                'doors'            => true,
                'bodystyle'        => true,
                'transmission'     => true,
                'odometer'         => true,
                'condition'        => true,
                'colorcombination' => [
                    'interiorcolor' => true,
                    'exteriorcolor' => true,
                    'preference'    => true,
                ],
                'imagetag'         => true,
                'price'            => true,
                'pricecomments'    => true,
                'option'           => [
                    'optionname'       => true,
                    'manufacturercode' => true,
                    'stock'            => true,
                    'weighting'        => true,
                    'price'            => true,
                ],
                'finance'          => [
                    'method'  => true,
                    'amount'  => true,
                    'balance' => true,
                ],
                'comments'         => true,
            ],
            'vendor'   => [
                'id'         => true,
                'vendorname' => true,
                'url'        => true,
                'contact'    => $this->_ADFPartContact,
            ],
            'provider' => [
                'id'      => true,
                'name'    => true,
                'service' => true,
                'url'     => true,
                'email'   => true,
                'phone'   => true,
                'contact' => $this->_ADFPartContact,
            ]
        ];
    }

    /**
     * @param string $selectedOption
     *
     * @return string
     */
    public function getADFFieldSelectOptionsHtml( $selectedOption = '' )
    {
        $outHtml = '';

        foreach ( $this->_ADFFullStructure as $rootLabel => $fieldData )
        {
            $outHtml .= '<optgroup label="' . $rootLabel . '">' . "\n";
            foreach ( $this->extractADFFields( $fieldData ) as $fieldPath )
            {
                $value = implode( '_', array_merge( [ $rootLabel ], $fieldPath ) );
                $outHtml .= '<option' . ( $selectedOption == $value ? ' selected="selected"' : '' ) . ' value="' . $value . '">' . self::GetSingleFieldText( array_merge( [ $rootLabel ], $fieldPath ) ) . '</option>' . "\n";
            }
            $outHtml .= '</optgroup>';
        }

        return $outHtml;
    }

    /**
     * @param $fieldData
     * @param array $result
     * @param array $fieldPath
     *
     * @return array
     */
    private function extractADFFields( $fieldData, &$result = [], $fieldPath = [] )
    {
        foreach ( $fieldData as $fieldName => $value )
        {
            if ( $value === true )
            {
                $result[] = array_merge( $fieldPath, [ $fieldName ] );
            }
            else
            {
                $fieldPath = array_merge( $fieldPath, [ $fieldName ] );
                $this->extractADFFields( $value, $result, $fieldPath );
                array_pop( $fieldPath );
            }
        }

        return $result;
    }

    /**
     * @param array $adfData
     *
     * @return string
     */
    public function generateADF( array $adfData )
    {
        $resultXml = new \DOMDocument( '1.0' );
        $resultXml->loadXML( '<?ADF VERSION="1.0"?><adf></adf>' );
        $adf = $resultXml->getElementsByTagName( 'adf' )->item( 0 );
        $i = 0;
        foreach ( $adfData as $leadData )
        {
            $adf->appendChild( ( new \DOMElement( 'prospect' ) ) );
            foreach ( $this->extractADFFields( $this->_ADFFullStructure ) as $fieldPath )
            {
                if ( isset( $leadData[implode( '_', $fieldPath )] ) )
                {
                    $tagValue = htmlspecialchars( trim( $leadData[implode( '_', $fieldPath )] ) );
                    $parent = $resultXml->getElementsByTagName( 'prospect' )->item( $i );
                    foreach ( $fieldPath as $tagName )
                    {
                        if ( $parent->getElementsByTagName( $tagName )->length == 0 )
                        {
                            $newNode = new \DOMElement( $tagName );
                            $parent->appendChild( $newNode );
                        }

                        $parent = $parent->getElementsByTagName( $tagName )->item( 0 );
                    }
                    $parent->nodeValue .= $tagValue;
                }
            }
            $i++;
        }

        return $resultXml->saveXML();
    }

    /**
     * @param string|array $field
     *
     * @return string
     */
    public static function GetSingleFieldText( $field )
    {
        if ( is_string( $field ) )
        {
            $field = explode( '_', $field );
        }

        return implode( ' 	&rarr; ', $field );
    }
}