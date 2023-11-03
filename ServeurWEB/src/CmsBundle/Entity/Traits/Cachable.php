<?php

namespace CmsBundle\Entity\Traits;

trait Cachable
{

    /**
     * @var boolean
     * @ORM\Column(name="cache", type="boolean", nullable=true)
     */
    protected $cache = false;

    /**
     * @var string
     * @ORM\Column(name="etag", type="string", length=255, nullable=true)
     */
    protected $etag;


    /**
     * @var integer
     * @ORM\Column(name="cache_time", type="integer", nullable=true)
     */
    protected $cacheTime;

    /**
     * @return bool
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param bool $cache
     * @return object $this
     */
    public function setCache(bool $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * @param string $etag
     * @return object
     */
    public function setEtag(string $etag)
    {
        $this->etag = $etag;

        return $this;
    }

    /**
     * @return int
     */
    public function getCacheTime()
    {
        return $this->cacheTime;
    }

    /**
     * @param int $cacheTime
     * @return object
     */
    public function setCacheTime(int $cacheTime)
    {
        $this->cacheTime = $cacheTime;

        return $this;
    }





}