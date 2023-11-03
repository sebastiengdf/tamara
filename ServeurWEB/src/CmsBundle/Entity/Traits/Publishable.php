<?php

namespace CmsBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait Publishable {

    /**
     * @var boolean
     * @Gedmo\Translatable
     * @ORM\Column(name="published", type="boolean", nullable=true)
     */
    protected $published = true;

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