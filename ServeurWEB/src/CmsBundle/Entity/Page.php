<?php

namespace CmsBundle\Entity;

use CmsBundle\Entity\Traits\Assetable;
use CmsBundle\Entity\Traits\Cachable;
use CmsBundle\Entity\Traits\Comptable;
use CmsBundle\Entity\Traits\Contentable;
use CmsBundle\Entity\Traits\Excerptable;
use CmsBundle\Entity\Traits\Layoutable;
use CmsBundle\Entity\Traits\Seoable;
use CmsBundle\Entity\Traits\Startable;
use CmsBundle\Entity\Traits\Nameable;
use CmsBundle\Entity\Traits\Publishable;
use CmsBundle\Entity\Traits\Sluggable;
use CoreBundle\Entity\Traits\Timestampable;
use CoreBundle\Entity\Traits\UniqueSluggable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;


/**
 * Page
 *
 * @ORM\Table(name="cms_page")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\PageTranslation")
 */
class Page extends AbstractPersonalTranslatable implements SeoEntityInterface, TranslatableInterface
{

    use Nameable;
    use Sluggable;
    use UniqueSluggable;
    use Contentable;
    use Excerptable;
    use Timestampable;
    use Publishable;
    use Startable;
    use Seoable;
    use Layoutable;
    use Assetable;
    use Comptable;
    use Cachable;
    use \AppBundle\Entity\Traits\CMS\Page;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CmsBundle\Entity\Folder")
     * @ORM\JoinColumn(nullable=true)
     */    
    protected $folder;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="CmsBundle\Entity\Translation\PageTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */

    protected $url;
    
    /**
     * @var boolean
     * @ORM\Column(name="show_builder", type="boolean", nullable=true)
     */   
    protected $showBuilder;

    /**
     * @var boolean
     * @ORM\Column(name="private_access", type="boolean", nullable=true)
     */

    protected $privateAccess;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Group")
     * @ORM\JoinTable(name="cms_page_groupe",
     *      joinColumns={@ORM\JoinColumn(name="page", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="groupe", referencedColumnName="id")}
     *      )
     * */
    private $allowedGroups;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->setCacheTime(600);
        $this->setPublishedStart(new  \DateTime());
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
     * Set folder
     *
     * @param \CmsBundle\Entity\Folder $folder
     *
     * @return Page
     */
    public function setFolder(\CmsBundle\Entity\Folder $folder = null)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return \CmsBundle\Entity\Folder
     */
    public function getFolder()
    {
        return $this->folder;
    }


    /**
     * Set url
     *
     * @param string $url
     *
     * @return Page
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    

    /**
     * Remove translation
     *
     * @param \CmsBundle\Entity\Translation\PageTranslation $translation
     */
    public function removeTranslation(\CmsBundle\Entity\Translation\PageTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Set showBuilder
     *
     * @param boolean $showBuilder
     *
     * @return Page
     */
    public function setShowBuilder($showBuilder)
    {
        $this->showBuilder = $showBuilder;

        return $this;
    }

    /**
     * Get showBuilder
     *
     * @return boolean
     */
    public function getShowBuilder()
    {
        return $this->showBuilder;
    }




    /**
     * Set privateAccess
     *
     * @param boolean $privateAccess
     *
     * @return Page
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
     * Add allowedGroup
     *
     * @param \UserBundle\Entity\Group $allowedGroup
     *
     * @return Page
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
