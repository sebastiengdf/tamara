<?php

namespace CoreBundle\Entity\Traits;

trait Contentable
{

    /**
     * @var string
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

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