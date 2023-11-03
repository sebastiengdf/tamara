<?php

namespace CmsBundle\Entity\Traits;

trait Coverable
{

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="cover", referencedColumnName="id", nullable=true)
     */
    protected $cover;

    /**
     * Set cover
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $cover
     * @return object
     */
    public function setCover(\Application\Sonata\MediaBundle\Entity\Media $cover = null)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getCover()
    {
        return $this->cover;
    }


}