<?php

namespace CmsBundle\Entity;

use CoreBundle\Entity\Traits\Positionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Picture
 *
 * @ORM\Table(name="cms_picture")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\PictureRepository")
 */
class Picture
{

    use Positionable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media", referencedColumnName="id", nullable=true)
     */
    protected $media;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AbstractPost", inversedBy="pictures")
     * @ORM\JoinColumn(name="post", referencedColumnName="id")
     */

    protected $post;


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
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     *
     * @return Picture
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set post
     *
     * @param \CmsBundle\Entity\AbstractPost $post
     *
     * @return Picture
     */
    public function setPost(\CmsBundle\Entity\AbstractPost $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \CmsBundle\Entity\AbstractPost
     */
    public function getPost()
    {
        return $this->post;
    }
}
