<?php

namespace CmsBundle\Entity\Traits;

trait Assetable
{

    /**
     * @var string
     * @ORM\Column(name="stylesheets", type="text", nullable=true)
     */
    protected $stylesheets;

    /**
     * @var string
     * @ORM\Column(name="javascripts", type="text", nullable=true)
     */
    protected $javascripts;

    /**
     * @return string
     */
    public function getStylesheets()
    {
        return $this->stylesheets;
    }

    /**
     * @param string $stylesheets
     * @return object
     */
    public function setStylesheets($stylesheets)
    {
        $this->stylesheets = $stylesheets;

        return $this;
    }

    /**
     * @return string
     */
    public function getJavascripts()
    {
        return $this->javascripts;
    }

    /**
     * @param string $javascripts
     * @return object
     */
    public function setJavascripts($javascripts)
    {
        $this->javascripts = $javascripts;

        return $this;
    }
    
    
    


}