<?php

namespace CmsBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait Excerptable
{

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="excerpt", type="text", nullable=true)
     */
    protected $excerpt;

    /**
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * @param string $excerpt
     * @return object
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }



}