<?php

namespace MQM\AssetBundle\Test\Asset;


use MQM\AssetBundle\Model\AssetManagerInterface;


class AssetManagerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{   
    protected $_container;
    
    /**
     * @var AssetManagerInterface
     */
    private $assetManager;


    public function __construct()
    {
        parent::__construct();
        
        $client = static::createClient();
        $container = $client->getContainer();
        $this->_container = $container;  
    }
    
    protected function setUp()
    {
        $this->assetManager = $this->get('mqm_asset.asset_manager');
    }

    protected function tearDown()
    {
        $this->resetAssets();
    }

    protected function get($service)
    {
        return $this->_container->get($service);
    }
    
    public function testGetAssertManager()
    {
        $this->assertNotNull($this->assetManager);
    }

    private function resetAssets()
    {
        $assets = $this->assetManager->findAssets();
        foreach ($assets as $asset) {
            $this->assetManager->deleteAsset($asset, false);
        }
        $this->assetManager->flush();
    }
}
