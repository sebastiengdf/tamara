<?php

namespace CmsBundle\Entity;

use CmsBundle\Entity\Traits\Nameable;
use CmsBundle\Entity\Traits\Sluggable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;

/**
 * Folder
 *
 * @ORM\Table(name="cms_folder")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\FolderRepository")
 * @Gedmo\TranslationEntity(class="CmsBundle\Entity\Translation\FolderTranslation")
 */
class Folder extends AbstractPersonalTranslatable implements TranslatableInterface
{
    use Nameable;
    use Sluggable;
    
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
     *     targetEntity="CmsBundle\Entity\Translation\FolderTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;


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
     * @param \CmsBundle\Entity\Translation\FolderTranslation $translation
     */
    public function removeTranslation(\CmsBundle\Entity\Translation\FolderTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }
}
