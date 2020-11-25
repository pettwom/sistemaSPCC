<?php

namespace Pagina\SpccBundle\Entity;

/**
 * Gallery
 */
class Gallery
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $imageGallery;

    /**
     * @var \DateTime
     */
    private $registerDate = 'now()';

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $ocupacionId;

    /**
     * @var boolean
     */
    private $state = true;

    /**
     * @var integer
     */
    private $typeId = '1';


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set imageGallery
     *
     * @param string $imageGallery
     *
     * @return Gallery
     */
    public function setImageGallery($imageGallery)
    {
        $this->imageGallery = $imageGallery;

        return $this;
    }

    /**
     * Get imageGallery
     *
     * @return string
     */
    public function getImageGallery()
    {
        return $this->imageGallery;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return Gallery
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * Get registerDate
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Gallery
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set ocupacionId
     *
     * @param integer $ocupacionId
     *
     * @return Gallery
     */
    public function setOcupacionId($ocupacionId)
    {
        $this->ocupacionId = $ocupacionId;

        return $this;
    }

    /**
     * Get ocupacionId
     *
     * @return integer
     */
    public function getOcupacionId()
    {
        return $this->ocupacionId;
    }

    /**
     * Set state
     *
     * @param boolean $state
     *
     * @return Gallery
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return boolean
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     *
     * @return Gallery
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->typeId;
    }
}

