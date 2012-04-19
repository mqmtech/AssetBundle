<?php

namespace MQM\AssetBundle\Helper;

use MQM\AssetBundle\Helper\AssetTemplateHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use MQM\AssetBundle\Helper\AssetFileHelper;
use MQM\AssetBundle\Helper\AssetDatabaseHelper;
use MQM\ToolsBundle\Utils;

class AssetTemplateHelper implements AssetTemplateHelperInterface
{
    private $request;
    private $fileHelper;
    private $databaseHelper;
    
    public function __construct(Request $request, AssetFileHelper $fileHelper, AssetDatabaseHelper $databaseHelper)
    {
        $this->request = $request;
        $this->fileHelper = $fileHelper;
        $this->databaseHelper = $databaseHelper;
    }
    
    public function getAssetWebPath($assetPath)
    {
        return $this->getAssetWebPathThroughDirectLink($assetPath);
    }
    
    private function getAssetWebPathThroughDirectLink($assetPath)
    {
        $rootPath = $this->fileHelper->getAppWebRootDir();
        $absolutePath = $rootPath . '/' . $assetPath;
        if (!file_exists($absolutePath)) {    
            $assetName = Utils::getInstance()->getLastPathSegment($assetPath);
            $rootPath = Utils::getInstance()->getSubstringTillMatches($absolutePath, $assetName);
            $this->databaseHelper->copyAssetFromDatabaseToFilesystemByAssetName($assetName, $rootPath);
        }
        
        return $this->getBaseWebPath() . '/'  . $assetPath;
    }
    
    private function getBaseWebPath()
    {
        return $this->request->getBasePath();
    }
}
