<?php

namespace CmsBundle\Entity;

use CmsBundle\Entity\Traits\Assetable;
use CmsBundle\Entity\Traits\Authorable;
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
use CmsBundle\Entity\Traits\Userable;
use CmsBundle\Util\ClassDetector;
use CoreBundle\Entity\Traits\Positionable;
use CoreBundle\Entity\Traits\Timestampable;
use CoreBundle\Entity\Traits\UniqueSluggable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;

/**
 * Post
 *
 * @ORM\Table(name="cms_post")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\AbstractPostRepository")
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\PostTranslation")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 */
abstract class AbstractPost extends AbstractPersonalTranslatable implements SeoEntityInterface, TranslatableInterface, PostInterface
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
    use Comptable;
    use Cachable;
    use Coverable;
    use Userable;
    use Authorable;
    use ClassDetector;
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="CmsBundle\Entity\Translation\PostTranslation",
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
     * @ORM\JoinTable(name="cms_post_groupe",
     *      joinColumns={@ORM\JoinColumn(name="post", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="groupe", referencedColumnName="id")}
     *      )
     * */
    protected $allowedGroups;

    /**
     * @ORM\OrderBy({"position" = "ASC"})
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Picture", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     */
    protected $pictures;

    /**
     * @ORM\OrderBy({"position" = "ASC"})
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Video", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     */
    protected $videos;


    /**
     * @ORM\OrderBy({"position" = "ASC"})
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\File", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     */
    protected $files;

    /**
     * @ORM\OrderBy({"position" = "ASC"})
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Field", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     */
    protected $fields;



    /**
     * @ORM\Column(name="top", type="boolean", nullable=true)
     */
    protected $top;

    /**
     * @ORM\Column(name="enable_comment", type="boolean", nullable=true)
     */
    protected $enableComment;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->setCacheTime(3600);
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
     * Set privateAccess
     *
     * @param boolean $privateAccess
     *
     * @return AbstractPost
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
     * @return AbstractPost
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
     * Set top
     *
     * @param boolean $top
     *
     * @return AbstractPost
     */
    public function setTop($top)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return boolean
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * Set enableComment
     *
     * @param boolean $enableComment
     *
     * @return AbstractPost
     */
    public function setEnableComment($enableComment)
    {
        $this->enableComment = $enableComment;

        return $this;
    }

    /**
     * Get enableComment
     *
     * @return boolean
     */
    public function getEnableComment()
    {
        return $this->enableComment;
    }

    /**
     * Add picture
     *
     * @param \CmsBundle\Entity\Picture $picture
     *
     * @return AbstractPost
     */
    public function addPicture(\CmsBundle\Entity\Picture $picture)
    {
        $this->pictures[] = $picture;
        $picture->setPost($this);
        return $this;
    }

    /**
     * Remove picture
     *
     * @param \CmsBundle\Entity\Picture $picture
     */
    public function removePicture(\CmsBundle\Entity\Picture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Add video
     *
     * @param \CmsBundle\Entity\Video $video
     *
     * @return AbstractPost
     */
    public function addVideo(\CmsBundle\Entity\Video $video)
    {
        $this->videos[] = $video;
        $video->setPost($this);
        return $this;
    }

    /**
     * Remove video
     *
     * @param \CmsBundle\Entity\Video $video
     */
    public function removeVideo(\CmsBundle\Entity\Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add file
     *
     * @param \CmsBundle\Entity\File $file
     *
     * @return AbstractPost
     */
    public function addFile(\CmsBundle\Entity\File $file)
    {
        $this->files[] = $file;
        $file->setPost($this);
        return $this;
    }

    /**
     * Remove file
     *
     * @param \CmsBundle\Entity\File $file
     */
    public function removeFile(\CmsBundle\Entity\File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add field
     *
     * @param \CmsBundle\Entity\Field $field
     *
     * @return AbstractPost
     */
    public function addField(\CmsBundle\Entity\Field $field)
    {
        $this->fields[] = $field;
        $field->setPost($this);
        return $this;
    }

    /**
     * Remove field
     *
     * @param \CmsBundle\Entity\Field $field
     */
    public function removeField(\CmsBundle\Entity\Field $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
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
