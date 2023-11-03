<?php

namespace CmsBundle\Entity;

use CmsBundle\Entity\Traits\Cachable;
use CmsBundle\Entity\Traits\Contentable;
use CmsBundle\Entity\Traits\Publishable;
use CoreBundle\Entity\Traits\Nameable;
use CoreBundle\Entity\Traits\UniqueSluggable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;

/**
 * Bloc
 *
 * @ORM\Table(name="cms_bloc")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\BlocRepository")
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\BlocTranslation")
 */
class Bloc extends AbstractPersonalTranslatable implements TranslatableInterface
{

    use Nameable;
    use UniqueSluggable;
    use Contentable;
    use Publishable;
    use Cachable;
    use \AppBundle\Entity\Traits\CMS\Bloc;

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
     *     targetEntity="CmsBundle\Entity\Translation\BlocTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    /**
     * Bloc constructor.
     */
    public function __construct()
    {
        $this->setCacheTime(60);
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
     * Remove translation
     *
     * @param \CmsBundle\Entity\Translation\BlocTranslation $translation
     */
    public function removeTranslation(\CmsBundle\Entity\Translation\BlocTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }
}
