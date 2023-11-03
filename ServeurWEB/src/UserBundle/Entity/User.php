<?php

namespace UserBundle\Entity;

use CoreBundle\Entity\Traits\Contentable;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Monolog\Logger;
use AppBundle\Entity\Approbation;
/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user_user")
 */
class User extends BaseUser
{

    use \AppBundle\Entity\Traits\User;

    use Contentable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Group")
     * @ORM\JoinTable(name="user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Image", cascade={"persist"})
     * 
     */
    protected $avatar;
    

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */    
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="notification", cascade={"persist", "remove"})
     */
    private $user;



    public function __construct()
    {
    	parent::__construct();
        $this->enabled = true;
        $this->roles = ['ROLE_ADMIN'];
    }

    public function __toString() : string
    {
        return ($this->getFirstname() != '' and $this->getLastname() != '') ? (string) $this->getFirstname().' '.$this->getLastname() : (string) $this->getUsername();
    }

    /**
     * Set avatar
     *
     * @param \CoreBundle\Entity\Image $avatar
     *
     * @return User
     */
    public function setAvatar(\CoreBundle\Entity\Image $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \CoreBundle\Entity\Image
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Get groups
     *
     * @return \UserBundle\Entity\Group
     */
    public function getGroups()
    {
        return $this->groups;
    }
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Approbation",mappedBy="approbateur",cascade={"persist", "remove"})
     */
    protected $approbation;
    
    
    public function AddApprobation(Approbation $approbation) {
    	 
    	 
    	$this->approbation[]=$approbation;
    	$approbation->setApprobateur($this);
    	return $this;
    }
    
}
