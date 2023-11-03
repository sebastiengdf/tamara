<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoreBundle\Entity\Traits\Nameable;

/**
 * Centrecout
 *
 * @ORM\Table(name="app_centrecout")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CentrecoutRepository")
 */
class Centrecout
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;
	
    use Nameable;

	public function __toString()
	{
	    return $this->getCode(). " - " .$this->getName();
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
     * Set code
     *
     * @param string $code
     *
     * @return Centrecout
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
