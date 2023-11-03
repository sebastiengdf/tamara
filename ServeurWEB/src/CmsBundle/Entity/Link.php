<?php

namespace CmsBundle\Entity;


use CmsBundle\Entity\Traits\Nameable;
use CmsBundle\Entity\Traits\Publishable;
use CmsBundle\Entity\Traits\Sluggable;
use CoreBundle\Entity\Traits\Positionable;
use CoreBundle\Entity\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\Menu\NodeInterface;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;

/**
 * link
 * @Gedmo\Tree(type="nested")
 * @ORM\Table("cms_link")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\LinkRepository")
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\LinkTranslation")
 */
class Link extends AbstractPersonalTranslatable implements TranslatableInterface, NodeInterface
{

        use Timestampable;
        use Nameable;
        use Sluggable;
        use Publishable;
        use Positionable;
        use \AppBundle\Entity\Traits\CMS\Link;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="link_type", type="string", length=255, nullable=true)
     */
    private $linkType;

    /**
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Translation\LinkTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;


    /**
     * @var boolean
     *
     * @ORM\Column(name="external", type="boolean", nullable=true)
     */
    private $external;

    /**
     * @var boolean
     *
     * @ORM\Column(name="root_link", type="boolean", nullable=true)
     */
    private $rootLink;

    /**
     * @var string
     * Gedmo\Translatable
     * @ORM\Column(name="link", type="text", nullable=true)
     */
    private $link;


    /**
     * @ORM\ManyToOne(targetEntity="CmsBundle\Entity\Page")
     * @ORM\JoinColumn(name="page", referencedColumnName="id", nullable=true)
     * */
    private $page;




    /**
     * @var string
     *
     * @ORM\Column(name="route_name", type="text", nullable=true)
     */
    private $routeName;

    /**
     * @ORM\ManyToMany(targetEntity="CmsBundle\Entity\Attribute", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="cms_link_route_args",
     *    joinColumns={@ORM\JoinColumn(name="link", referencedColumnName="id", onDelete="CASCADE")},
     *    inverseJoinColumns={@ORM\JoinColumn(name="route_arg", referencedColumnName="id", onDelete="CASCADE")})
     */
    protected $routeArgs;

    /**
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\Attribute", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="cms_link_children_attribute",
     *    joinColumns={@ORM\JoinColumn(name="link", referencedColumnName="id", onDelete="CASCADE")},
     *    inverseJoinColumns={@ORM\JoinColumn(name="children_attribute", referencedColumnName="id", onDelete="CASCADE")})
     */
    protected $childrenAttributes;

    /**
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\Attribute", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="cms_link_link_attribute",
     *    joinColumns={@ORM\JoinColumn(name="link", referencedColumnName="id", onDelete="CASCADE")},
     *    inverseJoinColumns={@ORM\JoinColumn(name="link_attribute", referencedColumnName="id", onDelete="CASCADE")})
     */
    protected $linkAttributes;

    /**
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\Attribute", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="cms_link_attribute",
     *    joinColumns={@ORM\JoinColumn(name="link", referencedColumnName="id", onDelete="CASCADE")},
     *    inverseJoinColumns={@ORM\JoinColumn(name="attribute", referencedColumnName="id", onDelete="CASCADE")})
     */
    protected $attributes;

    /**
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\Attribute", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="cms_link_param",
     *    joinColumns={@ORM\JoinColumn(name="link", referencedColumnName="id", onDelete="CASCADE")},
     *    inverseJoinColumns={@ORM\JoinColumn(name="param", referencedColumnName="id", onDelete="CASCADE")})
     */
    protected $linkParams;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="CmsBundle\Entity\Link", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Link", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->childrenAttributes = new ArrayCollection();
        $this->linkAttributes = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->rootLink = false;
        $this->routeArgs = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set external
     *
     * @param boolean $external
     * @return Link
     */
    public function setExternal($external)
    {
        $this->external = $external;

        return $this;
    }

    /**
     * Get external
     *
     * @return boolean
     */
    public function getExternal()
    {
        return $this->external;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    public function generateHref()
    {

        if ($this->getPage()) {
            return $this->getPage()->getUrl();
        }

        $href = '';

        if ($this->link) {
            $href .= $this->link;
            if ($this->getLinkParams()) {
                $href .= '?';
                foreach ($this->getLinkParams() as $linkParam) {
                    $href .= $linkParam->getName().'='.$linkParam->getValue().'&';
                }
                $href = substr($href, 0, -1);
            }

            return $href;
        }
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set page
     *
     * @param \CmsBundle\Entity\Page $page
     * @return Link
     */
    public function setPage(\CmsBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \CmsBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Link
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Link
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Link
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Link
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param \CmsBundle\Entity\Link $parent
     * @return Link
     */
    public function setParent(\CmsBundle\Entity\Link $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \CmsBundle\Entity\Link
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \CmsBundle\Entity\Link $children
     * @return Link
     */
    public function addChild(\CmsBundle\Entity\Link $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \CmsBundle\Entity\Link $children
     */
    public function removeChild(\CmsBundle\Entity\Link $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set rootLink
     *
     * @param boolean $rootLink
     * @return Link
     */
    public function setRootLink($rootLink)
    {
        $this->rootLink = $rootLink;

        return $this;
    }

    /**
     * Get rootLink
     *
     * @return boolean
     */
    public function getRootLink()
    {
        return $this->rootLink;
    }

    public function getOptions()
    {

        return array(
            'uri' => '/'.$this->generateHref(),
            'label' => $this->getName(),
            'attributes' => $this->getDataArray($this->getAttributes()),
            'linkAttributes' => $this->getDataArray($this->getLinkAttributes()),
            'childrenAttributes' => $this->getDataArray($this->getChildrenAttributes()),
            'labelAttributes' => array(),
            'extras' => array(
                'linkType' => $this->getLinkType(),
                'freeLink' => $this->getPage(),
                'external' => $this->getExternal(),
                'link' => $this->generateHref(),
                'routeName' => $this->getRouteName(),
                'routeArgs' => $this->getDataArray($this->getRouteArgs()),
                'page' => $this->getPage(),
//                'article' => $this->getArticle(),
//                'category' => $this->getCategory(),
            ),
            'current' => null,
            'display' => $this->getPublished(),
            'displayChildren' => true,
        );
    }

    public function getDataArray($data)
    {
        $r = array();
        foreach ($data as $item) {
            $r[$item->getName()] = $item->getValue();
        }

        return $r;
    }

    /**
     * Add childrenAttributes
     *
     * @param \CoreBundle\Entity\Attribute $childrenAttributes
     * @return Link
     */
    public function addChildrenAttribute(\CoreBundle\Entity\Attribute $childrenAttributes)
    {
        $this->childrenAttributes[] = $childrenAttributes;

        return $this;
    }

    /**
     * Remove childrenAttributes
     *
     * @param \CoreBundle\Entity\Attribute $childrenAttributes
     */
    public function removeChildrenAttribute(\CoreBundle\Entity\Attribute $childrenAttributes)
    {
        $this->childrenAttributes->removeElement($childrenAttributes);
    }

    /**
     * Get childrenAttributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildrenAttributes()
    {
        return $this->childrenAttributes;
    }

    /**
     * Add linkAttributes
     *
     * @param \CoreBundle\Entity\Attribute $linkAttributes
     * @return Link
     */
    public function addLinkAttribute(\CoreBundle\Entity\Attribute $linkAttributes)
    {
        $this->linkAttributes[] = $linkAttributes;

        return $this;
    }

    /**
     * Remove linkAttributes
     *
     * @param \CoreBundle\Entity\Attribute $linkAttributes
     */
    public function removeLinkAttribute(\CoreBundle\Entity\Attribute $linkAttributes)
    {
        $this->linkAttributes->removeElement($linkAttributes);
    }

    /**
     * Get linkAttributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLinkAttributes()
    {
        return $this->linkAttributes;
    }

    /**
     * Add attributes
     *
     * @param \CoreBundle\Entity\Attribute $attributes
     * @return Link
     */
    public function addAttribute(\CoreBundle\Entity\Attribute $attributes)
    {
        $this->attributes[] = $attributes;

        return $this;
    }

    /**
     * Remove attributes
     *
     * @param \CoreBundle\Entity\Attribute $attributes
     */
    public function removeAttribute(\CoreBundle\Entity\Attribute $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * Get attributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Add linkParams
     *
     * @param \CoreBundle\Entity\Attribute $linkParams
     * @return Link
     */
    public function addLinkParam(\CoreBundle\Entity\Attribute $linkParams)
    {
        $this->linkParams[] = $linkParams;

        return $this;
    }

    /**
     * Remove linkParams
     *
     * @param \CoreBundle\Entity\Attribute $linkParams
     */
    public function removeLinkParam(\CoreBundle\Entity\Attribute $linkParams)
    {
        $this->linkParams->removeElement($linkParams);
    }

    /**
     * Get linkParams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLinkParams()
    {
        return $this->linkParams;
    }

    /**
     * Remove translation
     *
     * @param \CmsBundle\Entity\Translation\LinkTranslation $translation
     */
    public function removeTranslation(\CmsBundle\Entity\Translation\LinkTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Set routeName
     *
     * @param string $routeName
     *
     * @return Link
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get routeName
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Add routeArg
     *
     * @param \CmsBundle\Entity\Attribute $routeArg
     *
     * @return Link
     */
    public function addRouteArg(\CmsBundle\Entity\Attribute $routeArg)
    {
        $this->routeArgs[] = $routeArg;

        return $this;
    }

    /**
     * Remove routeArg
     *
     * @param \CmsBundle\Entity\Attribute $routeArg
     */
    public function removeRouteArg(\CmsBundle\Entity\Attribute $routeArg)
    {
        $this->routeArgs->removeElement($routeArg);
    }

    /**
     * Get routeArgs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRouteArgs()
    {
        return $this->routeArgs;
    }

    public function getDataRouteArgsTranslated($locale)
    {
        $routeArgs = $this->getRouteArgs();
        $DataRouteArgsTranslated = array();

        foreach ($routeArgs as $routeArg) {
            $DataRouteArgsTranslated[$routeArg->getName()] = $routeArg->getTranslation('value', $locale);
        }

        return $DataRouteArgsTranslated;
    }

    /**
     * Set linkType
     *
     * @param string $linkType
     *
     * @return Link
     */
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;

        return $this;
    }

    /**
     * Get linkType
     *
     * @return string
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

}
