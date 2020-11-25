<?php

namespace Pagina\SpccBundle\Entity;

/**
 * Link
 */
class Link
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $tituloEnlace;

    /**
     * @var string
     */
    private $descriptionEnlace;

    /**
     * @var string
     */
    private $linkEnlace;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var boolean
     */
    private $state = true;

    /**
     * @var \DateTime
     */
    private $registerDate;


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
     * Set tituloEnlace
     *
     * @param string $tituloEnlace
     *
     * @return Link
     */
    public function setTituloEnlace($tituloEnlace)
    {
        $this->tituloEnlace = $tituloEnlace;

        return $this;
    }

    /**
     * Get tituloEnlace
     *
     * @return string
     */
    public function getTituloEnlace()
    {
        return $this->tituloEnlace;
    }

    /**
     * Set descriptionEnlace
     *
     * @param string $descriptionEnlace
     *
     * @return Link
     */
    public function setDescriptionEnlace($descriptionEnlace)
    {
        $this->descriptionEnlace = $descriptionEnlace;

        return $this;
    }

    /**
     * Get descriptionEnlace
     *
     * @return string
     */
    public function getDescriptionEnlace()
    {
        return $this->descriptionEnlace;
    }

    /**
     * Set linkEnlace
     *
     * @param string $linkEnlace
     *
     * @return Link
     */
    public function setLinkEnlace($linkEnlace)
    {
        $this->linkEnlace = $linkEnlace;

        return $this;
    }

    /**
     * Get linkEnlace
     *
     * @return string
     */
    public function getLinkEnlace()
    {
        return $this->linkEnlace;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Link
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
     * @return Link
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
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return Link
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
     * @var string
     */
    private $linkTitle;

    /**
     * @var string
     */
    private $descriptionLink;

    /**
     * @var string
     */
    private $link;


    /**
     * Set linkTitle
     *
     * @param string $linkTitle
     *
     * @return Link
     */
    public function setLinkTitle($linkTitle)
    {
        $this->linkTitle = $linkTitle;

        return $this;
    }

    /**
     * Get linkTitle
     *
     * @return string
     */
    public function getLinkTitle()
    {
        return $this->linkTitle;
    }

    /**
     * Set descriptionLink
     *
     * @param string $descriptionLink
     *
     * @return Link
     */
    public function setDescriptionLink($descriptionLink)
    {
        $this->descriptionLink = $descriptionLink;

        return $this;
    }

    /**
     * Get descriptionLink
     *
     * @return string
     */
    public function getDescriptionLink()
    {
        return $this->descriptionLink;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
}
