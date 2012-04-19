<?php

namespace MQM\AssetBundle\Model;

interface AssetInterface
{
    /**
     * @return string 
     */
    public function getName();
    
    /**
     * @param string 
     */
    public function setName($name);
    
    /**
     * @return string 
     */
    public function getType();
    
    /**
     * @param string 
     */
    public function setType($type);
    
    /**
     * @return blob 
     */
    public function getData();
    
    /**
     * @param blob 
     */
    public function setData($data);
}