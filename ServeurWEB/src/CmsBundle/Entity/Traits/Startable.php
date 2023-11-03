<?php

namespace CmsBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait Startable
{

    /**
     * @var \DateTime
     * @ORM\Column(name="published_start", type="datetime", nullable=true)
     */

    protected $publishedStart;
    /**
     * @var \DateTime
     * @ORM\Column(name="published_end", type="datetime", nullable=true)
     */

    protected $publishedEnd;

    public function __construct()
    {
        $this->publishedStart = new \DateTime();
    }


    /**
     * @return \DateTime
     */
    public function getPublishedStart()
    {
        return $this->publishedStart;
    }

    /**
     * @param \DateTime $publishedStart
     * @return object
     */
    public function setPublishedStart($publishedStart)
    {
        $this->publishedStart = $publishedStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedEnd()
    {
        return $this->publishedEnd;
    }

    /**
     * @param \DateTime $publishedEnd
     * @return object
     */
    public function setPublishedEnd($publishedEnd)
    {
        $this->publishedEnd = $publishedEnd;

        return $this;
    }



}