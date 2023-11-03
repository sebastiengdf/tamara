<?php

namespace CmsBundle\Entity;

use CmsBundle\Entity\Traits\Cachable;
use CoreBundle\Entity\Traits\Contentable;
use CoreBundle\Entity\Traits\Nameable;
use CoreBundle\Entity\Traits\UniqueSluggable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Slider
 *
 * @ORM\Table(name="cms_collection")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\CollectionRepository")
 */
class Collection
{

    use Nameable;
    use UniqueSluggable;
    use Cachable;
    use Contentable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OrderBy({"position" = "DESC"})
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Item", mappedBy="collection")
     * */
    protected $items;


    /**
     * @var string
     * @ORM\Column(name="vue", type="string", length=255)
     */
    protected $vue;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCacheTime(600);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set vue
     *
     * @param string $vue
     *
     * @return Collection
     */
    public function setVue($vue)
    {
        $this->vue = $vue;

        return $this;
    }

    /**
     * Get vue
     *
     * @return string
     */
    public function getVue()
    {
        return $this->vue;
    }

    /**
     * Add item
     *
     * @param \CmsBundle\Entity\Item $item
     *
     * @return Collection
     */
    public function addItem(\CmsBundle\Entity\Item $item)
    {
        $this->items[] = $item;
        $item->setCollection($this);
        return $this;
    }

    /**
     * Remove item
     *
     * @param \CmsBundle\Entity\Item $item
     */
    public function removeItem(\CmsBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
