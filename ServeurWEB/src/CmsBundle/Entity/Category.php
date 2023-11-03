<?php

namespace CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleCategory
 * @ORM\Table("cms_article_category")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\CategoryRepository")
 */
class Category extends AbstractTaxonomy
{

    protected $type = 'category';

    /**
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Article", mappedBy="category")
     * */
    protected $items;

    public function __construct()
    {
        parent::__construct();
        $this->items = new ArrayCollection();
    }

    /**
     * Add item
     *
     * @param \CmsBundle\Entity\Article $item
     *
     * @return Category
     */
    public function addItem(\CmsBundle\Entity\Article $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \CmsBundle\Entity\Article $item
     */
    public function removeItem(\CmsBundle\Entity\Article $item)
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

    /**
     * Get noIndex
     *
     * @return boolean
     */
    public function getNoIndex()
    {
        return $this->noIndex;
    }
}
