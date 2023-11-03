<?php

namespace CoreBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints\NotBlank;


trait Nameable {

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     * @NotBlank()
     */
    private $name;

    public function __toString() : string
    {
        return (string) $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return object
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

}