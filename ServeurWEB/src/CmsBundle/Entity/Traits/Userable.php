<?php

namespace CmsBundle\Entity\Traits;

trait Userable
{

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     * */
    protected $user;

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return Article
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

}