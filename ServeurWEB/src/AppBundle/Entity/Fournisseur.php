<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoreBundle\Entity\Traits\Nameable;
use CoreBundle\Entity\Traits\Publishable;

/**
 * Fournisseur
 *
 * @ORM\Table(name="app_fournisseur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FournisseurRepository")
 */
class Fournisseur
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

    /**
     * @var int
     * @ORM\Column(name="delai_date_echeance", type="integer")
     */
    private $delai_date_echeance;
	
    use Nameable;
	use Publishable;
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
     * Constructor
     */
    public function __construct()
    {
    	$this->delai_date_echeance = 30;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Fournisseur
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

    /**
     * Set delaiDateEcheance
     *
     * @param int $delaiDateEcheance
     *
     * @return Fournisseur
     */
    public function setDelaiDateEcheance($delai_date_echeance)
    {
        $this->delai_date_echeance = $delai_date_echeance;

        return $this;
    }

    /**
     * Get delaiDateEcheance
     *
     * @return int
     */

    public function getDelaiDateEcheance()
    {
        return $this->delai_date_echeance;
    }
}
