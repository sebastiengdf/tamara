<?php

namespace CmsBundle\Entity;

use CmsBundle\Entity\AbstractPost;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Slide
 *
 * @ORM\Table(name="cms_item")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\ItemRepository")
 */
class Item extends AbstractPost
{

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="background", referencedColumnName="id", nullable=true)
     */
    protected $background;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="cta_text", type="string", length=255, nullable=true)
     */
    protected $ctaText;


    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="cta_url", type="string", length=255, nullable=true)
     */
    protected $ctaUrl;


    /**
     * @ORM\ManyToOne(targetEntity="CmsBundle\Entity\Collection", inversedBy="items")
     * @ORM\JoinColumn(name="slider", referencedColumnName="id", nullable=true)
     * */
    protected $collection;



    /**
     * Set ctaText
     *
     * @param string $ctaText
     *
     * @return Item
     */
    public function setCtaText($ctaText)
    {
        $this->ctaText = $ctaText;

        return $this;
    }

    /**
     * Get ctaText
     *
     * @return string
     */
    public function getCtaText()
    {
        return $this->ctaText;
    }

    /**
     * Set ctaUrl
     *
     * @param string $ctaUrl
     *
     * @return Item
     */
    public function setCtaUrl($ctaUrl)
    {
        $this->ctaUrl = $ctaUrl;

        return $this;
    }

    /**
     * Get ctaUrl
     *
     * @return string
     */
    public function getCtaUrl()
    {
        return $this->ctaUrl;
    }

    /**
     * Set background
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $background
     *
     * @return Item
     */
    public function setBackground(\Application\Sonata\MediaBundle\Entity\Media $background = null)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set collection
     *
     * @param \CmsBundle\Entity\Collection $collection
     *
     * @return Item
     */
    public function setCollection(\CmsBundle\Entity\Collection $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \CmsBundle\Entity\Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }
}
