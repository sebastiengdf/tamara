<?php

namespace CmsBundle\Entity;

use CoreBundle\Entity\Traits\Positionable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;


/**
 * Field
 *
 * @ORM\Table(name="cms_field")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\FieldRepository")
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\FieldTranslation")
 */
class Field extends AbstractPersonalTranslatable implements TranslatableInterface
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
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Translation\FieldTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AbstractPost", inversedBy="fields")
     * @ORM\JoinColumn(name="article", referencedColumnName="id")
     */

    protected $post;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;


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
     * Set name
     *
     * @param string $name
     *
     * @return Field
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Field
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Remove translation
     *
     * @param \CmsBundle\Entity\Translation\FieldTranslation $translation
     */
    public function removeTranslation(\CmsBundle\Entity\Translation\FieldTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }



    /**
     * Set post
     *
     * @param \CmsBundle\Entity\AbstractPost $post
     *
     * @return Field
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
