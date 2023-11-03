<?php

namespace CmsBundle\Entity;

use CoreBundle\Entity\Traits\Nameable;
use Doctrine\ORM\Mapping as ORM;

/**
 * menuType
 *
 * @ORM\Table("cms_menu_type")
 * @ORM\Entity
 */
class MenuType
{

    use Nameable;

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
	 * @ORM\Column(name="template_path", type="text")
	 */
	private $templatePath;

	/**
	 * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Menu", mappedBy="menuType")
	 * */
	private $menus;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->menus = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * Set templatePath
	 *
	 * @param string $templatePath
	 * @return MenuType
	 */
	public function setTemplatePath($templatePath)
	{
		$this->templatePath = $templatePath;

		return $this;
	}

	/**
	 * Get templatePath
	 *
	 * @return string 
	 */
	public function getTemplatePath()
	{
		return $this->templatePath;
	}

	/**
	 * Add menus
	 *
	 * @param \CmsBundle\Entity\Menu $menus
	 * @return MenuType
	 */
	public function addMenu(\CmsBundle\Entity\Menu $menus)
	{
		$this->menus[] = $menus;
		$menus->setMenuType($this);
		return $this;
	}

	/**
	 * Remove menus
	 *
	 * @param \CmsBundle\Entity\Menu $menus
	 */
	public function removeMenu(\CmsBundle\Entity\Menu $menus)
	{
		$this->menus->removeElement($menus);
	}

	/**
	 * Get menus
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getMenus()
	{
		return $this->menus;
	}

}
