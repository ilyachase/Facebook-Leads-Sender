<?php

namespace app\models;

use app\models\Activerecord\Rulesets;

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

    /** @var array */
    private $_ADFAdditionalAttributes = [
        'customer_contact_name' => [ 'part' => 'full', 'type' => 'individual' ],
    ];

    /** @var array */
    private $_ADFAdditionalTags;

    public function __construct()
    {
        $this->_ADFFullStructure = [
            'customer' => [
                'contact'   => $this->_ADFPartContact,
                'id'        => true,
                'timeframe' => [
                    'description'  => true,
                    'earliestdate' => true,
                    'latestdate'   => true,
                ],
                'comments'  => true,
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
     * @param string $question
     *
     * @return string
     */
    public function getADFFieldSelectOptionsHtml( $selectedOption = '', $question = '' )
    {
        $outHtml = '';

        $foundSelected = false;
        foreach ( $this->_ADFFullStructure as $rootLabel => $fieldData )
        {
            $outHtml .= '<optgroup label="' . $rootLabel . '">' . "\n";
            foreach ( $this->extractADFFields( $fieldData ) as $fieldPath )
            {
                $detectedShouldBeSelected = self::_DetectIsADFOptionSelected( $question, array_merge( [ $rootLabel ], $fieldPath ) );
                $value = implode( '_', array_merge( [ $rootLabel ], $fieldPath ) );
                $outHtml .= '<option' . ( ( $selectedOption == $value || !$foundSelected && $detectedShouldBeSelected ) ? ' selected="selected"' : '' ) . ' value="' . $value . '">' . self::GetSingleFieldText( array_merge( [ $rootLabel ], $fieldPath ) ) . '</option>' . "\n";
                if ( !$foundSelected && $detectedShouldBeSelected )
                    $foundSelected = true;
            }
            $outHtml .= '</optgroup>';
        }

        return $outHtml;
    }

    /**
     * @param string $question
     * @param array $fieldPath
     *
     * @return bool
     */
    private static function _DetectIsADFOptionSelected( $question, array $fieldPath )
    {
        if ( !$question || current( $fieldPath ) != 'customer' )
            return false;

        foreach ( $fieldPath as $fileItem )
        {
            foreach ( explode( ' ', mb_strtolower( $question ) ) as $questionPart )
            {
                if ( $questionPart == $fileItem )
                    return true;
            }
        }

        if ( implode( '_', $fieldPath ) == 'customer_comments' )
            return true;

        return false;
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
     * @param Rulesets $ruleset
     *
     * @return string
     */
    public function generateADF( array $adfData, Rulesets $ruleset )
    {
        $resultXml = new \DOMDocument( '1.0' );
        $resultXml->loadXML( '<?ADF VERSION="1.0"?><adf></adf>' );
        $adf = $resultXml->getElementsByTagName( 'adf' )->item( 0 );
        $i = 0;
        foreach ( $adfData as $leadData )
        {
            if ( count( $this->_ADFAdditionalTags ) )
            {
                $leadData = array_merge( $leadData, $this->_ADFAdditionalTags );
            }

            $adf->appendChild( ( new \DOMElement( 'prospect' ) ) );

            foreach ( $this->extractADFFields( $this->_ADFFullStructure ) as $fieldPath )
            {
                $key = implode( '_', $fieldPath );

                if ( isset( $leadData[$key] ) )
                {
                    $connection = $ruleset->getConnectionByAdfFieldId( $key );

                    $tagValue = ( $connection && $connection->includeQuestion ? $connection->leadgenFieldQuestion . ' - ' : '' ) . htmlspecialchars( trim( $leadData[$key] ) );
                    $parent = $resultXml->getElementsByTagName( 'prospect' )->item( $i );

                    $_i = 0;
                    foreach ( $fieldPath as $tagName )
                    {
                        $_i++;
                        if ( $parent->getElementsByTagName( $tagName )->length == 0 )
                        {
                            $newNode = $resultXml->createElement( $tagName );

                            if ( isset( $this->_ADFAdditionalAttributes[$key] ) && count( $fieldPath ) == $_i )
                            {
                                foreach ( $this->_ADFAdditionalAttributes[$key] as $attributeName => $attributeValue )
                                    $newNode->setAttribute( $attributeName, $attributeValue );
                            }

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

    /**
     * @param string $adfFieldKey
     * @param string $attrName
     * @param string $attrValue
     *
     * @return ADFGenerator $this
     */
    public function addAdditionalAttribute( $adfFieldKey, $attrName, $attrValue )
    {
        if ( !isset( $this->_ADFAdditionalAttributes[$adfFieldKey] ) )
            $this->_ADFAdditionalAttributes[$adfFieldKey] = [];

        $this->_ADFAdditionalAttributes[$adfFieldKey] = array_merge( $this->_ADFAdditionalAttributes[$adfFieldKey], [ $attrName => $attrValue ] );

        return $this;
    }

    /**
     * @param string $tagKey
     * @param string $tagValue
     *
     * @return ADFGenerator $this
     */
    public function addAdditionalTag( $tagKey, $tagValue )
    {
        $this->_ADFAdditionalTags[$tagKey] = $tagValue;

        return $this;
    }
}