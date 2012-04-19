<?php

namespace MQM\AssetBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AssetExtension extends \Twig_Extension
{
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function getName()
    {
        return 'mqm_asset.twig_extension';
    }

    public function getFunctions()
    {
        return array(
            'mqm_asset' => new \Twig_Function_Method($this, 'getAssetWebPath'),
        );
    }
    
    public function getFilters()
    {
        return array(
        );
    }
    
    public function getAssetWebPath($assetName)
    {
        return $this->container->get('mqm_asset.template_helper')->getAssetWebPath($assetName);
    }
}