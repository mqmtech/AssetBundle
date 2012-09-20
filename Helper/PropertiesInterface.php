<?php

namespace MQM\AssetBundle\Helper;

interface PropertiesInterface
{
    /**
     * @param string|null
     * 
     * @return PropertiesInterface for a fluent interface
     */
    public function parse($path = null);
    
    /**
     * @param string 
     */
    public function getProperty($property);
    
    /**
     * @param string
     * @param string 
     * @return PropertiesInterface for a fluent interface
     */
    public function setProperty($property, $value);
}