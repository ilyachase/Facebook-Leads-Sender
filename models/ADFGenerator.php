<?php

namespace app\models;

class ADFGenerator
{
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
        ]
    ];

    /** @var array */
    private $_ADFFullStructure;

    public function __construct()
    {
        $this->_ADFFullStructure = [
            'customer' => [
                'id'        => true,
                'comments'  => true,
                'timeframe' => [
                    'description'  => true,
                    'earliestdate' => true,
                    'latestdate'   => true,
                ],
                'contact'   => $this->_ADFPartContact,
            ],
        ];
    }

    /**
     * @return string
     */
    public function getADFFieldSelectOptionsHtml()
    {
        $outHtml = '';

        foreach ( $this->_ADFFullStructure as $rootLabel => $fieldData )
        {
            $outHtml .= '<optgroup label="' . $rootLabel . '">' . "\n";
            foreach ( $this->extractADFFields( $fieldData ) as $fieldPath )
            {
                $outHtml .= '<option value="' . implode( '_', array_merge( [ $rootLabel ], $fieldPath ) ) . '">' . implode( ' 	&rarr; ', array_merge( [ $rootLabel ], $fieldPath ) ) . '</option>' . "\n";
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
                $fieldPath = [];
            }
        }

        return $result;
    }
}