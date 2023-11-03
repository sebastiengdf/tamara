<?php

namespace CmsBundle\Entity;

use CmsBundle\Entity\Traits\Assetable;
use CmsBundle\Entity\Traits\Cachable;
use CmsBundle\Entity\Traits\Comptable;
use CmsBundle\Entity\Traits\Contentable;
use CmsBundle\Entity\Traits\Coverable;
use CmsBundle\Entity\Traits\Excerptable;
use CmsBundle\Entity\Traits\Layoutable;
use CmsBundle\Entity\Traits\Nameable;
use CmsBundle\Entity\Traits\Seoable;
use CmsBundle\Entity\Traits\Sluggable;
use CoreBundle\Entity\Traits\Timestampable;
use CoreBundle\Entity\Traits\UniqueSluggable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;

/**
 * ListSeo
 *
 * @ORM\Table(name="cms_list_seo")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\ListSeoRepository")
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\ListSeoTranslation")
 */
class ListSeo extends AbstractPersonalTranslatable implements SeoEntityInterface, TranslatableInterface
{

    use Nameable;
    use Sluggable;
    use UniqueSluggable;
    use Excerptable;
    use Contentable;
    use Timestampable;
    use Coverable;
    use Layoutable;
    use Assetable;
    use Cachable;
    use Seoable;
    use Comptable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="CmsBundle\Entity\Translation\ListSeoTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    /**
     * @var boolean
     * @ORM\Column(name="allow_single", type="boolean", nullable=true)
     */
    protected $allowSingle = true;
    /**
     * @var boolean
     * @ORM\Column(name="allow_single_ajax", type="boolean", nullable=true)
     */
    protected $allowSingleAjax = true;

    /**
     * @var boolean
     * @ORM\Column(name="allow_list", type="boolean", nullable=true)
     */
    protected $allowList = true;


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
     * Get noIndex
     *
     * @return boolean
     */
    public function getNoIndex()
    {
        return $this->noIndex;
    }

    /**
     * Remove translation
     *
     * @param \CmsBundle\Entity\Translation\ListSeoTranslation $translation
     */
    public function removeTranslation(\CmsBundle\Entity\Translation\ListSeoTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }



    /**
     * Set allowSingle
     *
     * @param boolean $allowSingle
     *
     * @return ListSeo
     */
    public function setAllowSingle($allowSingle)
    {
        $this->allowSingle = $allowSingle;

        return $this;
    }

    /**
     * Get allowSingle
     *
     * @return boolean
     */
    public function getAllowSingle()
    {
        return $this->allowSingle;
    }

    /**
     * Set allowList
     *
     * @param boolean $allowList
     *
     * @return ListSeo
     */
    public function setAllowList($allowList)
    {
        $this->allowList = $allowList;

        return $this;
    }

    /**
     * Get allowList
     *
     * @return boolean
     */
    public function getAllowList()
    {
        return $this->allowList;
    }

    /**
     * Set allowSingleAjax
     *
     * @param boolean $allowSingleAjax
     *
     * @return ListSeo
     */
    public function setAllowSingleAjax($allowSingleAjax)
    {
        $this->allowSingleAjax = $allowSingleAjax;

        return $this;
    }

    /**
     * Get allowSingleAjax
     *
     * @return boolean
     */
    public function getAllowSingleAjax()
    {
        return $this->allowSingleAjax;
    }
}
