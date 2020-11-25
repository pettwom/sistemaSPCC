<?php

namespace Pagina\SpccBundle\Entity;

/**
 * Spcc
 */
class Spcc
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $mission;

    /**
     * @var string
     */
    private $view;

    /**
     * @var string
     */
    private $objetive;

    /**
     * @var string
     */
    private $legalFramework;

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
     * Set mission
     *
     * @param string $mission
     *
     * @return Spcc
     */
    public function setMission($mission)
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * Get mission
     *
     * @return string
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set view
     *
     * @param string $view
     *
     * @return Spcc
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set objetive
     *
     * @param string $objetive
     *
     * @return Spcc
     */
    public function setObjetive($objetive)
    {
        $this->objetive = $objetive;

        return $this;
    }

    /**
     * Get objetive
     *
     * @return string
     */
    public function getObjetive()
    {
        return $this->objetive;
    }

    /**
     * Set legalFramework
     *
     * @param string $legalFramework
     *
     * @return Spcc
     */
    public function setLegalFramework($legalFramework)
    {
        $this->legalFramework = $legalFramework;

        return $this;
    }

    /**
     * Get legalFramework
     *
     * @return string
     */
    public function getLegalFramework()
    {
        return $this->legalFramework;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return Spcc
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
     * @return Spcc
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
     * @return Spcc
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
