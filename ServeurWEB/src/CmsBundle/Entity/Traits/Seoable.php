<?php

namespace CmsBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

Trait Seoable
{

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="h1", type="string", length=255, nullable=true)
     */
    protected $H1;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="meta_description", type="text", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="meta_keyword", type="text", nullable=true)
     */
    protected $metaKeyword;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="other_meta", type="text", nullable=true)
     */
    protected $otherMeta;

    /**
     * @var boolean
     * @Gedmo\Translatable
     * @ORM\Column(name="no_index", type="boolean", nullable=true)
     */
    protected $noIndex;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return object
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getH1()
    {
        return $this->H1;
    }

    /**
     * @param string $H1
     * @return object
     */
    public function setH1($H1)
    {
        $this->H1 = $H1;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     * @return object
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaKeyword()
    {
        return $this->metaKeyword;
    }

    /**
     * @param string $metaKeyword
     * @return object
     */
    public function setMetaKeyword($metaKeyword)
    {
        $this->metaKeyword = $metaKeyword;

        return $this;
    }

    /**
     * @return string
     */
    public function getOtherMeta()
    {
        return $this->otherMeta;
    }

    /**
     * @param string $otherMeta
     * @return object
     */
    public function setOtherMeta($otherMeta)
    {
        $this->otherMeta = $otherMeta;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNoIndex()
    {
        return $this->noIndex;
    }

    /**
     * @param bool $noIndex
     * @return object
     */
    public function setNoIndex(bool $noIndex)
    {
        $this->noIndex = $noIndex;

        return $this;
    }


    
    

}