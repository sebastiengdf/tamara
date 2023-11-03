<?php

namespace CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;

/**
 * Attribute
 *
 * @ORM\Table("cms_attribute")
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\AttributeRepository")
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\AttributeTranslation")
 */
class Attribute extends AbstractPersonalTranslatable implements TranslatableInterface
{

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

    /**
     * @ORM\OneToMany(targetEntity="CmsBundle\Entity\Translation\AttributeTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var string
	 * @Gedmo\Translatable
	 * @ORM\Column(name="value", type="string", length=255)
	 */
	private $value;
	
	public function __toString()
	{
		return $this->getName().' => '.$this->getValue();
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
	 * Set name
	 *
	 * @param string $name
	 * @return Attribute
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
	 * @return Attribute
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
     * @param \CmsBundle\Entity\Translation\AttributeTranslation $translation
     */
    public function removeTranslation(\CmsBundle\Entity\Translation\AttributeTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }
}
