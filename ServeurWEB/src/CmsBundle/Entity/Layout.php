<?php

namespace CmsBundle\Entity;

use CoreBundle\Entity\Traits\Contentable;
use CoreBundle\Entity\Traits\Nameable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Layout
 *
 * @ORM\Table(name="cms_layout")
 * @ORM\Entity(repositoryClass="CmsBundle\Repository\LayoutRepository")
 */
class Layout
{

    use Nameable;
    use Contentable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
