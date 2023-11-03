<?php

namespace CoreBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait Positionable {

    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * Set position
     *
     * @param integer $position
     * @return object
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

}