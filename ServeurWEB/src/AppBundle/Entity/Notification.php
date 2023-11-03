<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var int
     *
     * @ORM\Column(name="statut_mail", type="integer")
     */
    private $statut_mail;

    /**
     * @return int
     */
    public function getStatutMail()
    {
        return $this->statut_mail;
    }

    /**
     * @param int $statut_mail
     */
    public function setStatutMail($statut_mail)
    {
        $this->statut_mail = $statut_mail;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime",nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Message", inversedBy="notification")
     * @ORM\JoinColumn(name="message", referencedColumnName="id", nullable=true)
     * */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="notification")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=true)
     * */
    protected $user;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Notification
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

}

