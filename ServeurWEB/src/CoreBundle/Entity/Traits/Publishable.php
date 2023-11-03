<?php

namespace CoreBundle\Entity\Traits;


trait Publishable {

    /**
     * @var boolean
     * @ORM\Column(name="published", type="boolean", nullable=true)
     */
    private $published = true;

    /**
     * Set published
     *
     * @param boolean $published
     * @return object
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

}