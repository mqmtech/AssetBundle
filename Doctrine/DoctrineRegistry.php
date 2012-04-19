<?php

namespace MQM\AssetBundle\Doctrine;

use MQM\AssetBundle\Doctrine\DBAL\Type\TypeLoader;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

class DoctrineRegistry
{
    private static $instance;
    
    private $entityManager;
    private $connection;
    private $params;
    
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DoctrineRegistry();
        }
        
        return self::$instance;
    }
    
    public function getEntityManager()
    {
        if ($this->entityManager == null) {
            $this->loadParameters();
            $this->createConnection();
            $this->loadTypes();
            $this->createEntityManager();
        }
        
        return $this->entityManager;
    }
    
    public function loadParameters($params = null)
    {
        if ($params == null) {
            $this->params = array(
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'user' => 'mqmtech_root',
                'password' => 'mqmd3vpass',
                'port' => '3306',
                'dbname' => 'mqmtech_tecnokey'
            );
        }
        else {
            $this->params = $params;
        }
    }
    
    private function createConnection()
    {
        $this->connection = DriverManager::getConnection($this->params);
        
        return $this->connection;
    }
    
    private function loadTypes()
    {
        TypeLoader::getInstance()->loadTypesToConnection($this->connection);
    }
    
   
    private function createEntityManager()
    {
        $annotationReader = new \Doctrine\Common\Annotations\AnnotationReader(); 
        $annotationReader->setDefaultAnnotationNamespace('Doctrine\ORM\Mapping\\'); 
        $annotationDriver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($annotationReader); 

        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataDriverImpl($annotationDriver);
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Types\Proxies');

        $this->entityManager = EntityManager::create($this->connection, $config);
        
        return $this->entityManager;
    }
    
    public function getConnection()
    {
        if ($this->connection == null) {
            $this->createConnection();
        }
        
        return $this->connection;
    }
}