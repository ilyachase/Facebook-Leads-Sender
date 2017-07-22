<?php

namespace app\models\adf;

class FBLeadsHelper
{
    /** @var \FacebookAds\Object\Lead[] */
    private $_objects = [];

    public function __construct( \FacebookAds\Cursor $leads )
    {
        $this->_objects = $leads->getArrayCopy();

        usort( $this->_objects, function ( \FacebookAds\Object\Lead $a, \FacebookAds\Object\Lead $b ) {
            return \DateTime::createFromFormat( \DateTime::W3C, $a->getData()['created_time'] )->getTimestamp() - \DateTime::createFromFormat( \DateTime::W3C, $b->getData()['created_time'] )->getTimestamp();
        } );
    }

    /**
     * @return int
     */
    public function getLastLeadTimestamp()
    {
        return \DateTime::createFromFormat( \DateTime::W3C, $this->_end( $this->_objects )->getData()['created_time'] )->getTimestamp();
    }

    /**
     * @param $timestamp
     *
     * @return \FacebookAds\Object\Lead[]
     */
    public function getLeadsAfterTimestamp( $timestamp )
    {
        $result = [];
        foreach ( $this->_objects as $lead )
        {
            if ( \DateTime::createFromFormat( \DateTime::W3C, $lead->getData()['created_time'] )->getTimestamp() <= $timestamp )
                continue;

            $result[] = $lead;
        }

        return $result;
    }

    /**
     * @param \FacebookAds\Object\Lead[] $objects
     *
     * @return \FacebookAds\Object\Lead
     */
    private function _end( array $objects )
    {
        return end( $objects );
    }
}