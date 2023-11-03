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
use CmsBundle\Entity\Traits\Publishable;
use CmsBundle\Entity\Traits\Seoable;
use CmsBundle\Entity\Traits\Sluggable;
use CmsBundle\Entity\Traits\Startable;
use CmsBundle\Util\ClassDetector;
use CoreBundle\Entity\Traits\Timestampable;
use CoreBundle\Entity\Traits\UniqueSluggable;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;

/**
 * Taxonomy
 *
 * @ORM\Table(name="cms_taxonomy")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\AbstractTaxonomyRepository")
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\TaxonomyTranslation")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 */
abstract class AbstractTaxonomy extends AbstractPersonalTranslatable implements SeoEntityInterface, TranslatableInterface, TaxonomyInterface
{

    use Nameable;
    use Sluggable;
    use UniqueSluggable;
    use Excerptable;
    use Contentable;
    use Timestampable;
    use Publishable;
    use Startable;
    use Seoable;
    use Layoutable;
    use Assetable;
    use Cachable;
    use Coverable;
    use ClassDetector;
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
     *     targetEntity="CmsBundle\Entity\Translation\TaxonomyTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    /**
     * @var boolean
     * @ORM\Column(name="private_access", type="boolean", nullable=true)
     */

    protected $privateAccess;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Group")
     * @ORM\JoinTable(name="cms_taxonomy_groupe",
     *      joinColumns={@ORM\JoinColumn(name="taxonomy", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="groupe", referencedColumnName="id")}
     *      )
     * */
    protected $allowedGroups;


    public function __construct()
    {
        $this->setCacheTime(600);
        $this->setPublishedStart(new \DateTime());
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
     * Set privateAccess
     *
     * @param boolean $privateAccess
     *
     * @return AbstractTaxonomy
     */
    public function setPrivateAccess($privateAccess)
    {
        $this->privateAccess = $privateAccess;

        return $this;
    }

    /**
     * Get privateAccess
     *
     * @return boolean
     */
    public function getPrivateAccess()
    {
        return $this->privateAccess;
    }

    /**
     * Remove translation
     *
     * @param \CmsBundle\Entity\Translation\PostTranslation $translation
     */
    public function removeTranslation(\CmsBundle\Entity\Translation\PostTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Add allowedGroup
     *
     * @param \UserBundle\Entity\Group $allowedGroup
     *
     * @return AbstractTaxonomy
     */
    public function addAllowedGroup(\UserBundle\Entity\Group $allowedGroup)
    {
        $this->allowedGroups[] = $allowedGroup;

        return $this;
    }

    /**
     * Remove allowedGroup
     *
     * @param \UserBundle\Entity\Group $allowedGroup
     */
    public function removeAllowedGroup(\UserBundle\Entity\Group $allowedGroup)
    {
        $this->allowedGroups->removeElement($allowedGroup);
    }

    /**
     * Get allowedGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllowedGroups()
    {
        return $this->allowedGroups;
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
