<?php

namespace CmsBundle\Entity\Traits;

trait Layoutable
{


    /**
     * @ORM\ManyToOne(targetEntity="CmsBundle\Entity\Layout")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $layout;


    /**
     * Set layout
     *
     * @param \CmsBundle\Entity\Layout $layout
     *
     * @return object
     */
    public function setLayout(\CmsBundle\Entity\Layout $layout = null)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get layout
     *
     * @return \CmsBundle\Entity\Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }

}