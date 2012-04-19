<?php

namespace MQM\AssetBundle\Model;

use MQM\AssetBundle\Model\AssetInterface;

interface AssetFactoryInterface
{
    /**
     *
     * @return AssetInterface
     */
    public function createAsset();

    /**
     *
     * @return string 
     */
    public function getAssetClass();
}


