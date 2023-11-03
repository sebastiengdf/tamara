<?php

namespace CmsBundle\Entity;

use CoreBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="cms_config")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\ConfigRepository")
 */
class Config
{

    use \AppBundle\Entity\Traits\ConfigCms;
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number_article", type="integer", length=255)
     */
    private $numberArticle = 12;
    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255)
     */
    private $theme = 'base';


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
     * Get numberArticle
     *
     * @return integer
     */
    public function getNumberArticle()
    {
        return $this->numberArticle;
    }

    /**
     * Set numberArticle
     *
     * @param integer $numberArticle
     *
     * @return Config
     */
    public function setNumberArticle($numberArticle)
    {
        $this->numberArticle = $numberArticle;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return Config
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }
}
