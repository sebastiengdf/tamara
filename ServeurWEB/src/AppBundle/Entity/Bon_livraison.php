<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoreBundle\Entity\Traits\Nameable;

/**
 * Bon_livraison
 *
 * @ORM\Table(name="app_bon_livraison")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Bon_livraisonRepository")
 */
class Bon_livraison
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

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture", inversedBy="bon_livraisons")
     * @ORM\JoinColumn(name="facture", referencedColumnName="id", nullable=true)
     * */
    protected $facture;

    /**
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Fichier", cascade={"persist"})
     * 
     */
    protected $fichier;
    
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
     * Set facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return Bon_livraison
     */
    public function setFacture(\AppBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \AppBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set fichier
     *
     * @param \CoreBundle\Entity\Fichier $fichier
     *
     * @return Bon_livraison
     */
    public function setFichier(\CoreBundle\Entity\Fichier $fichier = null)
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * Get fichier
     *
     * @return \CoreBundle\Entity\Fichier
     */
    public function getFichier()
    {
        return $this->fichier;
    }
}
