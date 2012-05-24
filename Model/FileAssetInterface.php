<?php

namespace MQM\AssetBundle\Model;

use MQM\AssetBundle\Model\AssetInterface;

interface FileAssetInterface extends AssetInterface
{    
    /**
     * @return string 
     */
    public function getAbsolutePath();

    /**
     * @return boolean
     */
    public function upload();
    
    /**
     * @return FileAssetInterface 
     */
    public function flush();

    /**
     * @return boolean
     */
    public function isFileUpdated();

    /**
     * @param boolean $fileUpdated 
     */
    public function setFileUpdated($fileUpdated);    

    /**
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * @return datetime 
     */
    public function getCreatedAt();

    /**
     * @param datetime $modifiedAt
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return datetime 
     */
    public function getModifiedAt();

    /**
     * @return FileAssetInterface
     */
    public function deleteFile();

    /**
     * @param string $baseRootDir
     * @return string filename
     */
    public function cloneFile($baseRootDir = null, $fileName = null);
}