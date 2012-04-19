<?php

namespace MQM\AssetBundle\Entity;

use MQM\AssetBundle\Model\AssetManagerInterface;
use MQM\AssetBundle\Model\AssetFactoryInterface;
use MQM\AssetBundle\Model\AssetInterface;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AssetManager implements AssetManagerInterface
{
    private $factory;
    private $entityManager;
    private $repository;
   
    public function __construct(EntityManager $entityManager, AssetFactoryInterface $assetFactory)
    {
        $this->entityManager = $entityManager;
        $this->factory = $assetFactory;
        $assetClass = $assetFactory->getAssetClass();
        $this->repository = $entityManager->getRepository($assetClass);
    }
    
    /**
     * {@inheritDoc} 
     */
    public function createAsset()
    {
        return $this->getFactory()->createAsset();
    }
    
    /**
     * {@inheritDoc} 
     */
    public function saveAsset(AssetInterface $asset, $andFlush = true)
    {
        $this->getEntityManager()->persist($asset);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * {@inheritDoc} 
     */
    public function deleteAsset(AssetInterface $asset, $andFlush = true)
    {
        $this->getEntityManager()->remove($asset);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }   
    
    /**
     * {@inheritDoc} 
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
        
        return $this;
    }
    
    public function findAssetBy(array $criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }
    
    public function findAssets()
    {
        return $this->getRepository()->findAll();
    }
    
    /**
     *
     * @return AssetFactory
     */
    protected function getFactory()
    {
        return $this->factory;
    }

    /**
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->repository;
    }
}