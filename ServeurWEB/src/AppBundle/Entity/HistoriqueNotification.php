<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="historique_notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HistoriqueNotificationRepository")
 */
class HistoriqueNotification
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
     * @ORM\Column(name="nbMessage", type="integer", nullable=true)
     */
    private $nbMessage;
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="facture", type="integer", nullable=true)
     */
    private $facture;

    /**
     * @return int
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * @param int $facture
     */
    public function setFacture($facture)
    {
        $this->facture = $facture;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="conversation", type="integer", nullable=true)
     */
    private $conversation;

    /**
     * @return int
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * @param int $conversation
     */
    public function setConversation($conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * @return int
     */
    public function getNbMessage()
    {
        return $this->nbMessage;
    }

    /**
     * @param int $nbMessage
     */
    public function setNbMessage($nbMessage)
    {
        $this->nbMessage = $nbMessage;
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

