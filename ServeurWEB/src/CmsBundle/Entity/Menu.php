<?php

namespace CmsBundle\Entity;

use CoreBundle\Entity\Traits\Nameable;
use CoreBundle\Entity\Traits\UniqueSluggable;
use CoreBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="cms_menu")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\MenuRepository")
 */
class Menu
{
    use Nameable;
    use UniqueSluggable;
    use Timestampable;
    use \AppBundle\Entity\Traits\CMS\Menu;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="CmsBundle\Entity\Link", cascade={"persist"})
     * *@ORM\JoinColumn(name="root_link", referencedColumnName="id", nullable=true)
     * */
    private $rootLink;

    /**
     * @ORM\ManyToOne(targetEntity="CmsBundle\Entity\MenuType", inversedBy="menus")
     * @ORM\JoinColumn(name="menu_type", referencedColumnName="id", nullable=true)
     * */
    private $menuType;



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
     * Set rootLink
     *
     * @param \CmsBundle\Entity\Link $rootLink
     *
     * @return Menu
     */
    public function setRootLink(\CmsBundle\Entity\Link $rootLink = null)
    {
        $this->rootLink = $rootLink;

        return $this;
    }

    /**
     * Get rootLink
     *
     * @return \CmsBundle\Entity\Link
     */
    public function getRootLink()
    {
        return $this->rootLink;
    }

    /**
     * Set menuType
     *
     * @param \CmsBundle\Entity\MenuType $menuType
     *
     * @return Menu
     */
    public function setMenuType(\CmsBundle\Entity\MenuType $menuType = null)
    {
        $this->menuType = $menuType;

        return $this;
    }

    /**
     * Get menuType
     *
     * @return \CmsBundle\Entity\MenuType
     */
    public function getMenuType()
    {
        return $this->menuType;
    }
}
