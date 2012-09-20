<?php

namespace MQM\AssetBundle\Helper;

use MQM\AssetBundle\Helper\PropertiesInterface;

class IniProperties implements PropertiesInterface
{       
    private $path;  
    private $properties; 
    
    /**
     * {@inheritDoc}
     */
    public function parse($path = null)
    {
        $this->path = $path;
        $this->properties = parse_ini_file($this->path);
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getProperties()
    {
        if ($this->properties == null) {
            $this->properties = parse_ini_file($this->path); 
        }
        
        return $this->properties;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getProperty($property)
    {
        $properties = $this->getProperties();        
        if ($properties != null) {
            if (isset ($properties[$property])) {
                return $properties[$property];
            }
        }
        
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function setProperty($property, $value)
    {
        $properties = $this->getProperties();
        $properties[$property] = $value;
        
        return $this;
    }
}