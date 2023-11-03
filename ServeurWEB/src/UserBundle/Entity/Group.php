<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class Group extends BaseGroup
{
    
    use \AppBundle\Entity\Traits\Group;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */    
    protected $color;

    public function __toString() : string
    {
        return (string) $this->getName();
    }

    public function __construct($name ='', $roles = array('ROLE_USER'))
    {
        $this->name = $name;
        $this->roles = $roles;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Group
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}
