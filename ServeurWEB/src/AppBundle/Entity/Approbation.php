<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Approbation
 *
 * @ORM\Table(name="approbation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApprobationRepository")
 */
class Approbation
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_demande_approbation", type="date", nullable=true)
     */
    private $dateDemandeApprobation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_approbation", type="date", nullable=true)
     */
    private $dateApprobation;

    
    public function __construct()
    {
    	$this->approuve=false;
    }
    /**
     * @var bool
     *
     * @ORM\Column(name="approuve", type="boolean")
     */
    private $approuve;


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
     * Set dateDemandeApprobation
     *
     * @param \DateTime $dateDemandeApprobation
     *
     * @return Approbation
     */
    public function setDateDemandeApprobation($dateDemandeApprobation)
    {
        $this->dateDemandeApprobation = $dateDemandeApprobation;

        return $this;
    }

    /**
     * Get dateDemandeApprobation
     *
     * @return \DateTime
     */
    public function getDateDemandeApprobation()
    {
        return $this->dateDemandeApprobation;
    }

    /**
     * Set dateApprobation
     *
     * @param \DateTime $dateApprobation
     *
     * @return Approbation
     */
    public function setDateApprobation($dateApprobation)
    {
        $this->dateApprobation = $dateApprobation;

        return $this;
    }

    /**
     * Get dateApprobation
     *
     * @return \DateTime
     */
    public function getDateApprobation()
    {
        return $this->dateApprobation;
    }

    /**
     * Set approuve
     *
     * @param boolean $approuve
     *
     * @return Approbation
     */
    public function setApprouve($approuve)
    {
        $this->approuve = $approuve;

        return $this;
    }

    /**
     * Get approuve
     *
     * @return bool
     */
    public function getApprouve()
    {
        return $this->approuve;
    }
 
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture",inversedBy="approbation")
     * @ORM\JoinColumn(name="facture", referencedColumnName="id", nullable=true)
     */
    protected $facture;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",inversedBy="approbation")
     * @ORM\JoinColumn(name="approbateur", referencedColumnName="id", nullable=true)
     */
    
    protected $approbateur;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Commentaire",cascade={"persist"}) 
     */
    protected $Commentaire;
    
	public function getFacture() {
		return $this->facture;
	}
	public function setFacture($facture) {
		$this->facture = $facture;
		return $this;
	}
	public function getApprobateur() {
		return $this->approbateur;
	}
	public function setApprobateur($approbateur) {
		$this->approbateur = $approbateur;
		return $this;
	}
	public function getCommentaire() {
		return $this->Commentaire;
	}
	public function setCommentaire($Commentaire) {
		$this->Commentaire = $Commentaire;
		return $this;
	}
	
	

}
