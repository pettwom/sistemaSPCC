<?php

namespace Pagina\SpccBundle\Entity;

/**
 * Slider
 */
class Slider
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $imageSlider;

    /**
     * @var \DateTime
     */
    private $registerDate;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var boolean
     */
    private $state = true;


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
     * Set imageSlider
     *
     * @param string $imageSlider
     *
     * @return Slider
     */
    public function setImageSlider($imageSlider)
    {
        $this->imageSlider = $imageSlider;

        return $this;
    }

    /**
     * Get imageSlider
     *
     * @return string
     */
    public function getImageSlider()
    {
        return $this->imageSlider;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return Slider
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
     * @return Slider
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
     * Set state
     *
     * @param boolean $state
     *
     * @return Slider
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
}
