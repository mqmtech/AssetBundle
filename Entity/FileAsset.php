<?php

namespace MQM\AssetBundle\Entity;

use MQM\AssetBundle\Model\FileAssetInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class FileAsset implements FileAssetInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;
    
    /**
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @ORM\Column(name="fileUpdated", type="boolean", nullable=true)
     */
    private $fileUpdated;

    /**
     * Virtual file field needed in the form
     * @Assert\File(maxSize="6000000")
     */
    public $data;
    
    public function __construct()
    {
        $this->setFileUpdated(false);
        $this->createdAt = new \DateTime();
    }
    
    function __clone()
    {
        $name = uniqid().'.jpg';//.$this->data->guessExtension());
        copy($this->getAbsolutePath(), $this->getAssetRootDir() . '/' . $name);
        $this->setName($name);
        if ($this->getName() == null) {
            $this->setName($this->getName());
        }
    }
    
    /**
     * @return {@inheritDoc}
     */
    public function __toString()
    {
        return '' . $this->name;
    }
    
    /**
     * @return {@inheritDoc}
     */
    public function getWebPath()
    {
        return $this->getAssetDir() . '/' . $this->getName();
    }
    
    /**
     * @return {@inheritDoc}
     */
    public function getAbsolutePath()
    {   
        return null === $this->getName() ? null : $this->getAssetRootDir() . '/' . $this->getName();
    }

    /**
     * @return {@inheritDoc}
     */
    protected function getAssetRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getAssetDir();
    }
    
    /**
     *
     * @return string get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
     */
    protected function getAssetDir()
    {        
        return 'uploads/images';
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
    public function isFileUpdated()
    {
        return $this->fileUpdated;
    }

    /**
     * @return {@inheritDoc}
     */
    public function setFileUpdated($fileUpdated)
    {
        $this->fileUpdated = $fileUpdated;
    }

    /**
     * @return {@inheritDoc}
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return {@inheritDoc}
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return {@inheritDoc}
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
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
    public function getName()
    {
        return $this->name;
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
        
    /**
     * @return {@inheritDoc}
     */
    public function getData($loadIfNotInMemory = false)
    {
        if ($this->data == null && $loadIfNotInMemory == true) {
            $absolutePath = $this->getAbsolutePath();
            $this->data = file_get_contents($absolutePath);
        }
        
        return $this->data;
    }
    
    /**
     * @return {@inheritDoc}
     */
    public function setData($data, $andFlush = false)
    {
        $this->data = $data;
        
        if ($andFlush == true) {
            $this->flush();
        }
    }
    
    /**
     * @return {@inheritDoc}
     */
    public function flush()
    {
        $absolutePath = $this->getAbsolutePath();
        file_put_contents($absolutePath, $this->data);
        
        return $this;
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->data) {
            return;
        }
        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->data->move($this->getAssetRootDir(), $this->getName());
        unset($this->data);
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->modifiedAt = new \DateTime();
        if (null != $this->data) {
            $this->setName(uniqid().'.jpg');//.$this->data->guessExtension());
        }
        if ($this->getName() == null) {
            $this->setName($this->getName());
        }
    }
    
     /**
     * Set the absolute path in the non-persistent variable file to be used in the postRemove if the remove is succesful
     * 
     * @ORM\PreRemove()
     */
    public function preRemove()
    {
        $name = $this->getName();        
        if ($name != null) {
            $this->data = $this->getAbsolutePath();
        }
    }
    
     /**
     * Deletes the file from the system completely
     * Reads the file variable which must have temporally the absolute path of the path setted in the PreRemove listener
     *
     * @ORM\PostRemove()
     */
    public function postRemove()
    {
        $absolutePath = $this->getData();
        if ($absolutePath != null) {
            try {
                unlink($absolutePath);
            }
            catch (\Exception $e) {
                
            }
        }
    }
}