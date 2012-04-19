<?php

namespace MQM\AssetBundle\Model;

use MQM\AssetBundle\Model\AssetInterface;

interface AssetManagerInterface
{
    /**
     * @return AssetInterface
     */
    public function createAsset();
    
    /**
     *
     * @param AssetInterface $asset
     * @param boolean $andFlush 
     */
    public function saveAsset(AssetInterface $asset, $andFlush = true);
    
    /**
     *
     * @param AssetInterface $asset
     * @param boolean $andFlush 
     */
    public function deleteAsset(AssetInterface $asset, $andFlush = true);    
    
    /**
     * @return AssetManagerInterface 
     */
    public function flush();
    
    /**
     * @param array 
     * @return AssetInterface
     */
    public function findAssetBy(array $criteria);
    
    /**
     * @return array 
     */
    public function findAssets();
}