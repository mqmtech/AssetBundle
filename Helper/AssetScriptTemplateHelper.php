<?php

namespace MQM\AssetBundle\Helper;

use MQM\AssetBundle\Helper\AssetTemplateHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;




class AssetScriptTemplateHelper implements AssetTemplateHelperInterface
{
    private $request;
    private $kernel;
    
    public function __construct(Request $request, KernelInterface $kernel)
    {
        $this->request = $request;
        $this->kernel = $kernel;
    }
    
    public function getAssetWebPath($assetPath)
    {
        return $this->getAssetWebPathThroughScript($assetPath);
    }
    
    private function getAssetWebPathThroughScript($assetName)
    {
        $env = $this->getEnvironment();
        $env = $env == 'prod' ? '' : '_' . $env;
        
        return $this->getBaseWebPath() . '/' . 'asset' . $env . '.php' . '/' . $assetName;
    }
    
    private function getBaseWebPath()
    {
        return $this->request->getBasePath();
    }

    private function getEnvironment()
    {
        return $this->kernel->getEnvironment();        
    }
}
