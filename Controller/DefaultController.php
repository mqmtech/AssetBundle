<?php

namespace MQM\AssetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('MQMAssetBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function createAction($name)
    {
        $this->create($name);        
        return $this->render('MQMAssetBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function showAction($name)
    {
        $data = $this->getDataFromDatabaseByName($name);
        //$data = $this->getDataFromFileSystemByName($name);
        $response = new Response($data, 200, array(
            'Content-Type' => 'image/jpeg'));
        
        return $response;
    }
    
    public function create($name)
    {
        $image = new \MQM\ImageBundle\Entity\Image();
        $image->setName('4f04947e6b9f6.jpg');
        $absolutePath = $image->getAbsolutePath();        
        $data = file_get_contents($absolutePath);
        
        $asset = $this->get('mqm_asset.asset_manager')->createAsset();
        $asset->setData($data);
        $asset->setName($name);
        $this->get('mqm_asset.asset_manager')->saveAsset($asset);
    }
    
    private function getDataFromFileSystemByName($name)
    {
        $image = new \MQM\ImageBundle\Entity\Image();
        $image->setName($name);
        $absolutePath = $image->getAbsolutePath();        
        $data = file_get_contents($absolutePath);
        
        return $data;
    }
    
    private function getDataFromDatabaseByName($name)
    {
        $assetManager = $this->get('mqm_asset.asset_manager');
        $asset = $assetManager->findAssetBy(array('name' => $name));        
        if ($asset == null) {
            $exception = $this->createNotFoundException('asset not found');
            throw $exception;
        }
        $data = $asset->getData();
        
        return $data;
    }
}
