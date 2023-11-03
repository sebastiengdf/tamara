<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoreBundle\Entity\Traits\Nameable;
use CoreBundle\Entity\Traits\Publishable;
use CoreBundle\Entity\Traits\Timestampable;
use CoreBundle\Entity\Traits\UniqueSluggable;
/**
 * Color
 *
 * @ORM\Table(name="app_color")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ColorRepository")
 */
class Color
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	use Nameable;
	use Publishable;
	use Timestampable;
	use UniqueSluggable;
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

