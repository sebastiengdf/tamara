<?php

namespace CmsBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait Sluggable
{

    /**
     * @var string
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
     */
    protected $slug;

    /**
     * Set slug
     *
     * @param string $slug
     * @return object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

}