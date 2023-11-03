<?php

namespace CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 * @ORM\Table("cms_article")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\ArticleRepository")
 */
class Article extends AbstractPost
{


    /**
     * @ORM\ManyToOne(targetEntity="CmsBundle\Entity\Category", inversedBy="items")
     * @ORM\JoinColumn(name="category", referencedColumnName="id", nullable=true)
     * */
    protected $category;

    /**
     * @ORM\ManyToMany(targetEntity="CmsBundle\Entity\Tag", inversedBy="items")
     * @ORM\JoinTable(name="cms_article_article_tags",
     *      joinColumns={@ORM\JoinColumn(name="post", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag", referencedColumnName="id")}
     *      )
     * */
    private $tags;


    /**
     * Set category
     *
     * @param \CmsBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\CmsBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \CmsBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tag
     *
     * @param \CmsBundle\Entity\Tag $tag
     *
     * @return Article
     */
    public function addTag(\CmsBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;
        $tag->addItem($this);
        return $this;
    }

    /**
     * Remove tag
     *
     * @param \CmsBundle\Entity\Tag $tag
     */
    public function removeTag(\CmsBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
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
