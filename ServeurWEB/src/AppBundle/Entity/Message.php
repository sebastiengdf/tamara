<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
    private $title;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Conversation", inversedBy="message")
     * @ORM\JoinColumn(name="conversation", referencedColumnName="id", nullable=true)
     * */
    protected $conversation;



    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="notification", cascade={"persist", "remove"})
     */
    private $message;
    

    /**
     * @var string
     *
     * @ORM\Column(name="createdmessage", type="string", length=255)
     */
    protected $createdmessage;

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Conversation
     */
    public function setCreatedMessage(\UserBundle\Entity\User $createdmessage = null)
    {
        $this->createdmessage = $createdmessage;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getCreatedMessage()
    {
        return $this->createdmessage;
    }


    /**
     * Set images
     *
     * @param string $images
     * @return User
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set Conversation
     *
     * @param \AppBundle\Entity\Conversation $conversation
     *
     * @return Conversation
     */
    public function setConversation(\AppBundle\Entity\Conversation $conversation = null)
    {
        $this->conversation = $conversation;

        return $this;
    }


    /**
     * Get user
     *
     * @return \AppBundle\Entity\Conversation
     */
    public function getConversation()
    {
        return $this->conversation;
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
     * @return Message
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

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}

