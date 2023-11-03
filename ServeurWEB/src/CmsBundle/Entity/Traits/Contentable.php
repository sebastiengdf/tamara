<?php

namespace CmsBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait Contentable
{

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Contentable
     */
    public function setContent($content = null)
    {
        $this->content = $content;

        return $this;
    }
    
    

}