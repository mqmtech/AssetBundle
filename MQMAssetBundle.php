<?php

namespace MQM\AssetBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use MQM\AssetBundle\Doctrine\DBAL\Type\TypeLoader;

class MQMAssetBundle extends Bundle
{
    public function boot()
    {
        $conn = $this->container->get('doctrine')->getConnection();
        TypeLoader::getInstance()->loadTypesToConnection($conn);
    }
}
