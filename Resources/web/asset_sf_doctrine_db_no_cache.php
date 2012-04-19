<?php

ini_set("memory_limit","512M");

require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';
require_once __DIR__.'/../app/AppCache.php';

use Symfony\Component\HttpFoundation\Request;
use MQM\ToolsBundle\Utils;

$kernel = new AppKernel('prod', true);
$kernel->loadClassCache();
$kernel = new AppCache($kernel);
$kernel->handle(Request::createFromGlobals());

    $em = $kernel->getKernel()->getContainer()->get('doctrine')->getEntityManager();
    $repo = $em->getRepository('\MQM\AssetBundle\Entity\BlobAsset');
    $assetName = Utils::getInstance()->getLastPathSegment($_SERVER['REQUEST_URI']);
    $asset = $repo->findOneBy(array('name' => $assetName));

    header('HTTP/1.0 200');
    header('Content-type: image/jpeg');
    echo($asset->getData());
    
    //DoctrineRegistry::getInstance()->getConnection()->close(); // TODO: investigate it whether it is really necessary to close a doctrine connection