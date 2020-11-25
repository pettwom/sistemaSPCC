<?php

namespace Pagina\SpccBundle\Entity;

/**
 * Release
 */
class Release
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $releases;

    /**
     * @var string
     */
    private $acceptance;

    /**
     * @var boolean
     */
    private $status = true;

    /**
     * @var \DateTime
     */
    private $registerDate = 'now()';

    /**
     * @var integer
     */
    private $userId;


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
     * Set releases
     *
     * @param string $releases
     *
     * @return Release
     */
    public function setReleases($releases)
    {
        $this->releases = $releases;

        return $this;
    }

    /**
     * Get releases
     *
     * @return string
     */
    public function getReleases()
    {
        return $this->releases;
    }

    /**
     * Set acceptance
     *
     * @param string $acceptance
     *
     * @return Release
     */
    public function setAcceptance($acceptance)
    {
        $this->acceptance = $acceptance;

        return $this;
    }

    /**
     * Get acceptance
     *
     * @return string
     */
    public function getAcceptance()
    {
        return $this->acceptance;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Release
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return Release
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
     * @return Release
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
}
