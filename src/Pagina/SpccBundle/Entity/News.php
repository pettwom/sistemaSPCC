<?php

namespace Pagina\SpccBundle\Entity;

/**
 * News
 */
class News
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titleNews;

    /**
     * @var \DateTime
     */
    private $dateNews;

    /**
     * @var string
     */
    private $shortNews;

    /**
     * @var string
     */
    private $longNews;

    /**
     * @var string
     */
    private $authorNews;

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
     * @var string
     */
    private $pathImage;


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
     * Set titleNews
     *
     * @param string $titleNews
     *
     * @return News
     */
    public function setTitleNews($titleNews)
    {
        $this->titleNews = $titleNews;

        return $this;
    }

    /**
     * Get titleNews
     *
     * @return string
     */
    public function getTitleNews()
    {
        return $this->titleNews;
    }

    /**
     * Set dateNews
     *
     * @param \DateTime $dateNews
     *
     * @return News
     */
    public function setDateNews($dateNews)
    {
        $this->dateNews = $dateNews;

        return $this;
    }

    /**
     * Get dateNews
     *
     * @return \DateTime
     */
    public function getDateNews()
    {
        return $this->dateNews;
    }

    /**
     * Set shortNews
     *
     * @param string $shortNews
     *
     * @return News
     */
    public function setShortNews($shortNews)
    {
        $this->shortNews = $shortNews;

        return $this;
    }

    /**
     * Get shortNews
     *
     * @return string
     */
    public function getShortNews()
    {
        return $this->shortNews;
    }

    /**
     * Set longNews
     *
     * @param string $longNews
     *
     * @return News
     */
    public function setLongNews($longNews)
    {
        $this->longNews = $longNews;

        return $this;
    }

    /**
     * Get longNews
     *
     * @return string
     */
    public function getLongNews()
    {
        return $this->longNews;
    }

    /**
     * Set authorNews
     *
     * @param string $authorNews
     *
     * @return News
     */
    public function setAuthorNews($authorNews)
    {
        $this->authorNews = $authorNews;

        return $this;
    }

    /**
     * Get authorNews
     *
     * @return string
     */
    public function getAuthorNews()
    {
        return $this->authorNews;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return News
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
     * @return News
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
     * @return News
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
     * Set pathImage
     *
     * @param string $pathImage
     *
     * @return News
     */
    public function setPathImage($pathImage)
    {
        $this->pathImage = $pathImage;

        return $this;
    }

    /**
     * Get pathImage
     *
     * @return string
     */
    public function getPathImage()
    {
        return $this->pathImage;
    }
}
