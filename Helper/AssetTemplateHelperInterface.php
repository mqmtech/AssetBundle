<?php

namespace MQM\AssetBundle\Helper;

interface AssetTemplateHelperInterface
{
    /**
     * @param string
     * @return string 
     */
    public function getAssetWebPath($assetPath);
}
