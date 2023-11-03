<?php


namespace CmsBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="cms_field_translation",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_translation_idx", columns={"locale", "object_id", "field"})}
 * )
 */
class FieldTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="CmsBundle\Entity\Field", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;

}
