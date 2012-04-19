<?php

namespace MQM\AssetBundle\Doctrine\DBAL\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Driver\Connection;

class TypeLoader
{
    /**
     * @var TypeLoader
     */
    private static $instance;
    
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new TypeLoader();
        }
        
        return self::$instance;
    }
    
    public function loadTypesToConnection(Connection $connection)
    {
        // If you have multiple connections, iterate over get('...')->getConnections();
        if (!Type::hasType('blob')) {
            Type::addType('blob', 'MQM\AssetBundle\Doctrine\DBAL\Type\BlobType');
            $connection->getDatabasePlatform()->registerDoctrineTypeMapping('blob','blob');        
        }
        
        if (!Type::hasType('mediumblob')) {
            Type::addType('mediumblob', 'MQM\AssetBundle\Doctrine\DBAL\Type\MediumBlobType');
            $connection->getDatabasePlatform()->registerDoctrineTypeMapping('mediumblob','mediumblob');        
        }
    }
}
