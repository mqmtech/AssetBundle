<?php

namespace MQM\AssetBundle\Entity;

use MQM\AssetBundle\Model\AssetFactoryInterface;

class AssetFactory implements AssetFactoryInterface
{
    private $assetClass;

    
    public function __construct($assetClass) {
        $this->assetClass = $assetClass;
    }
    
    /**
     * {@inheritDoc}
     */
    public function createAsset()
    {
        return new $this->assetClass();
    }

    /**
     * {@inheritDoc}
     */
    public function getAssetClass()
    {
        return $this->assetClass;
    }
}