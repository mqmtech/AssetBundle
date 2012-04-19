<?php

namespace MQM\AssetBundle\Helper;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use MQM\ToolsBundle\IO\ReaderInterface;

class AssetFileHelper
{
    private $kernel;
    private $configReader;
    
    public function __construct(KernelInterface $kernel, ReaderInterface $configReader)
    {
        $this->kernel = $kernel;
        $this->configReader = $configReader;
    }
    
    public function copyScriptsFromBundleToAppWebRootDir()
    {
        $bundleWebDir = $this->getBundleWebRootDir();
        $appWebDir = $this->getAppWebRootDir();
        
        $assetDevContents = file_get_contents($bundleWebDir . '/' . 'asset_doctrine_db_cache.php');
        file_put_contents($appWebDir . '/' . 'asset_dev.php', $assetDevContents);
        
        $assetContents = file_get_contents($bundleWebDir . '/' . 'asset_native_db_cache.php');
        $assetContents = $this->loadDBDatabaseConfigToScript($assetContents);
        file_put_contents($appWebDir . '/' . 'asset.php', $assetContents);
    }
    
    private function loadDBDatabaseConfigToScript($script)
    {
        $rootDir = $this->kernel->getRootDir();
        $configDir = $rootDir . '/' . 'config' . '/' . 'parameters.ini';
        $this->configReader->parse($configDir);
        
        $database_host = $this->configReader->getProperty('database_host');
        $database_user = $this->configReader->getProperty('database_user');
        $database_password = $this->configReader->getProperty('database_password');
        $database_name = $this->configReader->getProperty('database_name');
        
        $script = str_replace('%database_user%', $database_user, $script);
        $script = str_replace('%database_password%', $database_password, $script);        
        $script = str_replace('%database_host%', $database_host, $script);
        $script = str_replace('%database_name%', $database_name, $script);
        
        return $script;
    }
    
    public function getBundleWebRootDir($subPath = '')
    {
        $bundleWebDir = __DIR__ . '/../Resources/web';        
        if (strlen($subPath) > 0) {
            $subPath = trim($subPath , '/');
            return $bundleWebDir . '/' . $subPath;            
        }
        else {
            return $bundleWebDir;
        }
    }
    
    public function getAppWebRootDir($subPath = '')
    {
        $rootDir = $this->kernel->getRootDir();
        $rootWebPath = $rootDir . '/../web';        
        if (strlen($subPath) > 0) {
            $subPath = trim($subPath , '/');
            return $rootWebPath . '/' . $subPath;            
        }
        else {
            return $rootWebPath;
        }
    }
}
