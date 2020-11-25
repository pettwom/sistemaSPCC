<?php

namespace Pagina\SpccBundle\Entity;

/**
 * Comments
 */
class Comments
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nameComment;

    /**
     * @var string
     */
    private $emailComment;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var boolean
     */
    private $status = true;

    /**
     * @var \DateTime
     */
    private $fechaReg;


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
     * Set nameComment
     *
     * @param string $nameComment
     *
     * @return Comments
     */
    public function setNameComment($nameComment)
    {
        $this->nameComment = $nameComment;

        return $this;
    }

    /**
     * Get nameComment
     *
     * @return string
     */
    public function getNameComment()
    {
        return $this->nameComment;
    }

    /**
     * Set emailComment
     *
     * @param string $emailComment
     *
     * @return Comments
     */
    public function setEmailComment($emailComment)
    {
        $this->emailComment = $emailComment;

        return $this;
    }

    /**
     * Get emailComment
     *
     * @return string
     */
    public function getEmailComment()
    {
        return $this->emailComment;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Comments
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
     * Set fechaReg
     *
     * @param \DateTime $fechaReg
     *
     * @return Comments
     */
    public function setFechaReg($fechaReg)
    {
        $this->fechaReg = $fechaReg;

        return $this;
    }

    /**
     * Get fechaReg
     *
     * @return \DateTime
     */
    public function getFechaReg()
    {
        return $this->fechaReg;
    }
}
