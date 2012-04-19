<?php

namespace MQM\AssetBundle\Helper;

use MQM\AssetBundle\Helper\AssetFileHelper;
use MQM\AssetBundle\Model\AssetManagerInterface;

class AssetDatabaseHelper
{
    /**
     * @var AssetManagerInterface 
     */
    private $assetManager;
    
    /**
     * @var AssetFileHelper
     */
    private $fileHelper;
    
    public function __construct(AssetFileHelper $fileHelper, AssetManagerInterface $assetManager)
    {
        $this->fileHelper = $fileHelper;
        $this->assetManager = $assetManager;
    }
    
    public function copyAssetsFromDatabaseToFilesystem($subPath)
    {
        $assetsRootPath = $this->fileHelper->getAppWebRootDir($subPath);
        $assets = $this->assetManager->findAssets();        
        for ($index = 0, $count = count($assets) ; $index < $count ; $index++) {
            $asset = $assets[$index];
            $this->copyAssetFromDatabaseToFilesystem($asset, $assetsRootPath);
        }
    }
    
    public function copyAssetFromDatabaseToFilesystemByAssetName($assetName, $assetRootPath)
    {
        $asset = $this->assetManager->findAssetBy(array('name' => $assetName));
        if ($asset == null) {
            return;
        }
        
        return $this->copyAssetFromDatabaseToFilesystem($asset, $assetRootPath);
    }
    
    public function copyAssetFromDatabaseToFilesystem($asset, $assetRootPath)
    {
        $name = $asset->getName();
        $absolutePath = $assetRootPath . '/' . $name;
        $data = $asset->getData();
        file_put_contents($absolutePath, $data);
    }
}
