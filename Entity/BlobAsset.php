<?php

namespace MQM\AssetBundle\Entity;

use MQM\AssetBundle\Model\AssetInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="mqm_asset")
 * @ORM\Entity
 */
class BlobAsset implements AssetInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;
    
    /**
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(name="data", type="mediumblob", nullable=true)
     */
    private $data;
    
    /**
     * @return {@inheritDoc}
     */
    public function getWebPath()
    {
        return $this->getName();
    }
    
    /**
     * @return {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return {@inheritDoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return {@inheritDoc}
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * @return {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return {@inheritDoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return {@inheritDoc}
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}