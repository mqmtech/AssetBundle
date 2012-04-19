<?php

// Turn off all error reporting as the error can be displayed as part of the image
error_reporting(0);

ini_set("memory_limit","512M");

require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'          => array(__DIR__.'/../vendor/symfony/src', __DIR__.'/../vendor/bundles'),
    'Doctrine\\Common' => __DIR__.'/../vendor/doctrine-common/lib',
    'Doctrine\\DBAL'   => __DIR__.'/../vendor/doctrine-dbal/lib',
    'Doctrine'         => __DIR__.'/../vendor/doctrine/lib',
    'MQM'              => __DIR__.'/../vendor/bundles',
));

$loader->registerNamespaceFallbacks(array(
    __DIR__.'/../src',
));
$loader->register();

AnnotationRegistry::registerLoader(function($class) use ($loader) {
    $loader->loadClass($class);
    return class_exists($class, false);
});
AnnotationRegistry::registerFile(__DIR__.'/../vendor/doctrine/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

use Symfony\Component\HttpFoundation\Request;
use MQM\AssetBundle\Doctrine\DoctrineRegistry;
use MQM\ToolsBundle\Utils;

    $scriptName = getScriptName();
    $startPosition = strpos($_SERVER['REQUEST_URI'], $scriptName) + strlen($scriptName);
    $assetPath = substr($_SERVER['REQUEST_URI'], $startPosition);
    $data = file_get_contents(__DIR__ . '/' . $assetPath);
    if ($data == false) {
        $assetName = Utils::getInstance()->getLastPathSegment($_SERVER['REQUEST_URI']);
        $em = DoctrineRegistry::getInstance()->getEntityManager();
        $repo = $em->getRepository('\MQM\AssetBundle\Entity\BlobAsset');
        $asset = $repo->findOneBy(array('name' => $assetName));
        $data = $asset->getData();
        file_put_contents(__DIR__ . '/' . $assetPath, $data);
    }
    header('HTTP/1.0 200');
    header('Content-type: image/jpeg');
    echo($data);   
    
    //DoctrineRegistry::getInstance()->getConnection()->close(); // TODO: investigate it whether it is really necessary to close a doctrine connection  

function getScriptName()
{
    $iPos = strrpos(__FILE__, "\\");
    $fileName = substr(__FILE__, $iPos + 1, strlen(__FILE__));
    
    return $fileName;
}