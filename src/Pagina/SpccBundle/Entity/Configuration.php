<?php

namespace Pagina\SpccBundle\Entity;

/**
 * Configuration
 */
class Configuration
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $config;

    /**
     * @var string
     */
    private $description;

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
     * Set config
     *
     * @param string $config
     *
     * @return Configuration
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Configuration
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return Configuration
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
     * @return Configuration
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
     * @return Configuration
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
