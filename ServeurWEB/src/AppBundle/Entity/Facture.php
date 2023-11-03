<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoreBundle\Entity\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use AppBundle\Validator\Constraints as AppAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\MappedSuperclass;
use WorkflowBundle\Entity\Document;
use Symfony\Component\Validator\Constraints\Date;
use setasign\Fpdi;
/**
 * Facture
 *
 * @ORM\Table(name="app_facture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactureRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *               fields={"name", "fournisseur"},
 *               errorPath="name",
 *               message="Ce numéro de facture est déjà utilisé pour ce fournisseur."
 *               )
 * @AppAssert\CheckNumSaisie
 * @AppAssert\CheckValide
 * @AppAssert\CheckBC
 * @AppAssert\CheckNumComptable
 * 
 */
class Facture extends Document
{
	

	/**
     * @return boolean
     */
    public function isLitige()
    {
        return $this->litige;
    }

    public function getLitige()
    {
        return $this->litige;
    }
    
    /**
     * @param boolean $litige
     */
    public function setLitige($litige)
    {
        $this->litige = $litige;
    }

    public function __toString() : string
{
        return (string) $this->getName();
    }
    
    
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
     * @ORM\Column(name="name", type="string", length=255)
     * @NotBlank()
     */
    protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Bon_commande", mappedBy="facture", cascade={"persist", "remove"})
     */
  	protected $bon_commandes;
  	
  	/**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Bon_livraison", mappedBy="facture", cascade={"persist", "remove"})
     */
  	public $bon_livraisons;
  	
  	
  	/**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Action", mappedBy="facture", cascade={"persist", "remove"})
     */
  	protected $actions;
  	
  	/**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commentaire", mappedBy="facture", cascade={"persist", "remove"})
     */
  	protected $commentaires;
    
  
  	/**
  	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Etiquettes", mappedBy="facture", cascade={"persist", "remove"})
  	 */
  	protected $etiquettes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Conversation", mappedBy="facture", cascade={"persist", "remove"})
     */
    protected $conversation;

    
    /**
     * @var string
     * @ORM\Column(name="date_saisie", type="datetime")
     */
    protected $date_saisie;
    
    /**
     * @var string
     * @ORM\Column(name="date_echeance", type="datetime", nullable=true)
     */
    protected $date_echeance;
    
	/**
     * @var string
     * @ORM\Column(name="num_saisie", type="string", length=255, nullable=true)
     */
    protected $num_saisie;
    
    /**
     * @var string
     * @ORM\Column(name="num_ordre", type="string", length=255, nullable=true)
     */
    protected $num_ordre;
    
    /**
     * @var string
     * @ORM\Column(name="num_immo", type="string", length=255, nullable=true)
     */
    protected $num_immo;
    
    /**
     * @var string
     * @ORM\Column(name="num_compte_comptable", type="string", length=255, nullable=true)
     */
    protected $num_compte_comptable;
    
    /**
     * @var string
     * @ORM\Column(name="montant_ttc", type="decimal", nullable=true, precision=14, scale=2)
     */
    protected $montant_ttc;

    /**
     * @var string
     * @ORM\Column(name="montant_ttc_usd", type="decimal", nullable=true, precision=14, scale=2)
     */
    protected $montant_ttc_usd;
    
    /**
     * @var boolean
     * @ORM\Column(name="check_bl", type="boolean")
     */
    protected $check_bl;

    /**
     * @var boolean
     * @ORM\Column(name="check_bc", type="boolean")
     */
    protected $check_bc;
    
    
    /**
     * @var boolean
     * @ORM\Column(name="litige", type="boolean", nullable=true))
     */
    protected $litige;
    
    /**
     * @var boolean
     * @ORM\Column(name="check_valide", type="boolean")
     */
    protected $check_valide;
    
    /**
     * @var boolean
     * @ORM\Column(name="check_paye", type="boolean")
     */
    protected $check_paye;
    
    /**
     * @var boolean
     * @ORM\Column(name="check_approuve", type="boolean")
     */
    protected $checkapprouve;
  

    /**
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Fichier", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    protected $fichier;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fournisseur")
     * @ORM\JoinColumn(name="fournisseur", referencedColumnName="id", nullable=true)
     * */
    protected $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Centrecout")
     * @ORM\JoinColumn(name="centrecout", referencedColumnName="id", nullable=true)
     * */
    protected $centrecout;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TVA")
     * @ORM\JoinColumn(name="tva", referencedColumnName="id", nullable=true)
     * */
    protected $tva;
    
	/**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="affectation", referencedColumnName="id", nullable=true)
     * */
    protected $affectation;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="affectationapprobation", referencedColumnName="id", nullable=true)
     * */
    protected $affectationapprobation;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fournisseur")
     * @ORM\JoinColumn(name="affactureur", referencedColumnName="id", nullable=true)
     * */
    protected $affactureur;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="createur", referencedColumnName="id", nullable=true)
     * */
    
    
    
    protected $approbateur;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="approbateur", referencedColumnName="id", nullable=true)
     * */
    
    protected $createur;

    /**
     * @ORM\ManyToOne(targetEntity="getMailFactBundle\Entity\Status")
     * @ORM\JoinColumn(name="statusf", referencedColumnName="id", nullable=true)
     */
    protected $statusf;
    
    /**
     * @ORM\ManyToOne(targetEntity="WorkflowBundle\Entity\WorkflowStep")
     * @ORM\JoinColumn(name="step", referencedColumnName="id", nullable=true)
     */
    protected $step;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Approbation",mappedBy="facture",cascade={"persist", "remove"})
     */
    protected $approbation;
 
    /**
     * @var string
     * @ORM\Column(name="$commentairapprobation", type="string", nullable=true)
     */
    protected $commentairapprobation;
    
    public function AddApprobation(Approbation $approbation) {
    	
    	
    	$this->approbation[]=$approbation;
    	$approbation->setFacture($this);
    	$approbation->setApprouve(false);
    	return $this;
    }
   
    public function getNextApprobateur(){
    	if($this->approbation!==null && count($this->approbation)>0)
    	{
    		foreach ($this->approbation as $approbation)
    			if(!($approbation->getApprouve()))
    				return $approbation->getApprobateur();
    	}
    	
    	return null;
    }
    
    
    public function getRank( $user){
    	$ranck=0;
    	if($this->approbation!==null && count($this->approbation)>0)
    	{
    		foreach ($this->approbation as $approbation){
    			if($approbation->getApprobateur()===$user)    		
    				return $ranck;
    			$ranck++;
    		}
    	}    	 
    	return $ranck;
    }
    public function setNextApprobateur(){
    	if($this->getNextApprobateur()!==null){
    		$this->approbateur=$this->getNextApprobateur();
    		return true;
    	}
    	return false;
    }
    public function UserSetApprobation($user, $approuve){
    	foreach ($this->approbation as $approbation){
    		if($approbation->getApprobateur()===$user){
    			{$approbation->setApprouve($approuve);
    			 $commentaire=new Commentaire();
    			 $commentaire->setContent($this->getCommentairapprobation());
    			 $commentaire->setUser($user);
    			 $approbation->setCommentaire($commentaire);
    		
    			 $this->setCommentairapprobation(null);
    			}
    		}
    	}
    }
    
    public function getAllapproved(){
    	if(count($this->approbation)===0)
    		return false;
    	foreach ($this->approbation as $approbation)
    		if(!($approbation->getApprouve()))
    			return false;
    	return true;
    }
    public function saveApprobation() {
    	 if($this->approbation!==null && count($this->approbation)>0)
    	 {
    	 	//$this->approbateur=$this->getNextApprobateur();
    	 	foreach ($this->approbation as $approbation)
    	 		$approbation->setFacture($this);
    	 }
   	 	 return $this;
    }
    
    /*public function removeApprobation(Approbation $approbation) {
    	$this->approbation->removeElement($approbation);
    	$approbation->setFacture(null);
    }
    */
    use Timestampable;
    
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
    	$this->check_valide = false;
        $this->check_paye = false;
        $this->checkapprouve = false;
        $this->check_bc = false;
        $this->bon_commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bon_livraisons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->approbation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * Set dateSaisie
     *
     * @param \DateTime $dateSaisie
     *
     * @return Facture
     */
    public function setDateSaisie($dateSaisie)
    {
        $this->date_saisie = $dateSaisie;

        return $this;
    }

    /**
     * Get dateSaisie
     *
     * @return \DateTime
     */
    public function getDateSaisie()
    {
        return $this->date_saisie;
    }

    /**
     * Set dateEcheance
     *
     * @param \DateTime $dateEcheance
     *
     * @return Facture
     */
    public function setDateEcheance($dateEcheance)
    {
        $this->date_echeance = $dateEcheance;

        return $this;
    }

    /**
     * Get dateEcheance
     *
     * @return \DateTime
     */
    public function getDateEcheance()
    {
        return $this->date_echeance;
    }

    /**
     * Set numSaisie
     *
     * @param string $numSaisie
     *
     * @return Facture
     */
    public function setNumSaisie($numSaisie)
    {
        $this->num_saisie = $numSaisie;

        return $this;
    }

    /**
     * Get numSaisie
     *
     * @return string
     */
    public function getNumSaisie()
    {
        return $this->num_saisie;
    }

    /**
     * Set numOrdre
     *
     * @param string $numOrdre
     *
     * @return Facture
     */
    public function setNumOrdre($numOrdre)
    {
        $this->num_ordre = $numOrdre;

        return $this;
    }

    /**
     * Get numOrdre
     *
     * @return string
     */
    public function getNumOrdre()
    {
        return $this->num_ordre;
    }

    /**
     * Set numImmo
     *
     * @param string $numImmo
     *
     * @return Facture
     */
    public function setNumImmo($numImmo)
    {
        $this->num_immo = $numImmo;

        return $this;
    }

    /**
     * Get numImmo
     *
     * @return string
     */
    public function getNumImmo()
    {
        return $this->num_immo;
    }

    /**
     * Set numCompteComptable
     *
     * @param string $numCompteComptable
     *
     * @return Facture
     */
    public function setNumCompteComptable($numCompteComptable)
    {
        $this->num_compte_comptable = $numCompteComptable;

        return $this;
    }

    /**
     * Get numCompteComptable
     *
     * @return string
     */
    public function getNumCompteComptable()
    {
        return $this->num_compte_comptable;
    }

    /**
     * Set montantTtc
     *
     * @param string $montantTtc
     *
     * @return Facture
     */
    public function setMontantTtc($montantTtc)
    {
        $this->montant_ttc = $montantTtc;

        return $this;
    }

    /**
     * Get montantTtc
     *
     * @return string
     */
    public function getMontantTtc()
    {
        return $this->montant_ttc;
    }

    /**
     * Set montantTtcUsd
     *
     * @param string $montantTtcUsd
     *
     * @return Facture
     */
    public function setMontantTtcUsd($montantTtcUsd)
    {
        $this->montant_ttc_usd = $montantTtcUsd;

        return $this;
    }

    /**
     * Get montantTtcUsd
     *
     * @return string
     */
    public function getMontantTtcUsd()
    {
        return $this->montant_ttc_usd;
    }

    /**
     * Set checkValide
     *
     * @param boolean $checkValide
     *
     * @return Facture
     */
    public function setCheckValide($checkValide)
    {
        $this->check_valide = $checkValide;

        return $this;
    }

    /**
     * Get checkValide
     *
     * @return boolean
     */
    public function getCheckvalide()
    {
        return $this->check_valide;
    }

    /**
     * Set checkPaye
     *
     * @param boolean $checkPaye
     *
     * @return Facture
     */
    public function setCheckPaye($checkPaye)
    {
        $this->check_paye = $checkPaye;

        return $this;
    }

    /**
     * Get checkPaye
     *
     * @return boolean
     */
    public function getCheckPaye()
    {
        return $this->check_paye;
    }

    /**
     * Add bonCommande
     *
     * @param \AppBundle\Entity\Bon_commande $bonCommande
     *
     * @return Facture
     */
    public function addBonCommande(\AppBundle\Entity\Bon_commande $bonCommande)
    {
    	$bonCommande->setFacture($this);
    	$this->bon_commandes[] = $bonCommande;
        return $this;
    }

    /**
     * Remove bonCommande
     *
     * @param \AppBundle\Entity\Bon_commande $bonCommande
     */
    public function removeBonCommande(\AppBundle\Entity\Bon_commande $bonCommande)
    {
        $this->bon_commandes->removeElement($bonCommande);
        $bonCommande->setFacture(null);
    }

    /**
     * Get bonCommandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBoncommandes()
    {
        return $this->bon_commandes;
    }

    /**
     * Add bonLivraison
     *
     * @param \AppBundle\Entity\Bon_livraison $bonLivraison
     *
     * @return Facture
     */
    public function addBonLivraison(\AppBundle\Entity\Bon_livraison $bonLivraison)
    {
        $this->bon_livraisons[] = $bonLivraison;
    
		$bonLivraison->setFacture($this);
        return $this;
    }

    /**
     * Remove bonLivraison
     *
     * @param \AppBundle\Entity\Bon_livraison $bonLivraison
     */
    public function removeBonLivraison(\AppBundle\Entity\Bon_livraison $bonLivraison)
    {
        $this->bon_livraisons->removeElement($bonLivraison);
        $bonLivraison->setFacture(null);
    }

    /**
     * Get bonLivraisons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBonLivraisons()
    {
        return $this->bon_livraisons;
    }

    /**
     * Add action
     *
     * @param \AppBundle\Entity\Action $action
     *
     * @return Facture
     */
    public function addAction(\AppBundle\Entity\Action $action)
    {
        $this->actions[] = $action;
		$action->setFacture($this);
        return $this;
    }

    /**
     * Remove action
     *
     * @param \AppBundle\Entity\Action $action
     */
    public function removeAction(\AppBundle\Entity\Action $action)
    {
        $this->actions->removeElement($action);
        $action->setFacture(null);
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Facture
     */
    public function addCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;
		$commentaire->setFacture($this);
        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
        $commentaire->setFacture(null);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set fichier
     *
     * @param \CoreBundle\Entity\Fichier $fichier
     *
     * @return Facture
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

    /**
     * Set fournisseur
     *
     * @param \AppBundle\Entity\Fournisseur $fournisseur
     *
     * @return Facture
     */
    public function setFournisseur(\AppBundle\Entity\Fournisseur $fournisseur)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \AppBundle\Entity\Fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set centrecout
     *
     * @param \AppBundle\Entity\Centrecout $centrecout
     *
     * @return Facture
     */
    public function setCentrecout(\AppBundle\Entity\Centrecout $centrecout)
    {
        $this->centrecout = $centrecout;

        return $this;
    }

    /**
     * Get centrecout
     *
     * @return \AppBundle\Entity\Centrecout
     */
    public function getCentrecout()
    {
        return $this->centrecout;
    }

    /**
     * Set tva
     *
     * @param \AppBundle\Entity\TVA $tva
     *
     * @return Facture
     */
    public function setTva(\AppBundle\Entity\TVA $tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return \AppBundle\Entity\TVA
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set checkBl
     *
     * @param boolean $checkBl
     *
     * @return Facture
     */
    public function setCheckBl($checkBl)
    {
        $this->check_bl = $checkBl;

        return $this;
    }

    /**
     * Get checkBl
     *
     * @return boolean
     */
    public function getCheckBl()
    {
        return $this->check_bl;
    }

    /**
     * Set checkBc
     *
     * @param boolean $checkBc
     *
     * @return Facture
     */
    public function setCheckbc($checkBc)
    {
        $this->check_bc = $checkBc;

        return $this;
    }

    /**
     * Get checkBc
     *
     * @return boolean
     */
    public function getCheckbc()
    {
        return $this->check_bc;
    }

    /**
     * Set affectation
     *
     * @param \UserBundle\Entity\User $affectation
     *
     * @return Facture
     */
    public function setAffectation(\UserBundle\Entity\User $affectation = null)
    {
        $this->affectation = $affectation;

        return $this;
    }

    /**
     * Get affectation
     *
     * @return \UserBundle\Entity\User
     */
    public function getAffectation()
    {
        return $this->affectation;
    }

    /**
     * Set affactureur
     *
     * @param \AppBundle\Entity\Fournisseur $affactureur
     *
     * @return Facture
     */
    public function setAffactureur(\AppBundle\Entity\Fournisseur $affactureur = null)
    {
        $this->affactureur = $affactureur;

        return $this;
    }

    /**
     * Get affactureur
     *
     * @return \AppBundle\Entity\Fournisseur
     */
    public function getAffactureur()
    {
        return $this->affactureur;
    }

    /**
     * Set createur
     *
     * @param \UserBundle\Entity\User $createur
     *
     * @return Facture
     */
    public function setCreateur(\UserBundle\Entity\User $createur)
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * Get createur
     *
     * @return \UserBundle\Entity\User
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * Set statusf
     *
     * @param \getMailFactBundle\Entity\Status $statusf
     *
     * @return Facture
     */
    public function setStatusf(\getMailFactBundle\Entity\Status $statusf)
    {
        $this->statusf = $statusf;

        return $this;
    }

    /**
     * Get statusf
     *
     * @return \getMailFactBundle\Entity\Status
     */
    public function getStatusf()
    {
        return $this->statusf;
    }
	public function getApprobateur() {
		return $this->approbateur;
	}
	public function setApprobateur($approbateur) {
		$this->approbateur = $approbateur;
		return $this;
	}
	public function getCheckapprouve() {
		return $this->checkapprouve;
	}
	public function setCheckapprouve( $checkapprouve) {
		$this->checkapprouve = $checkapprouve;
		return $this;
	}

	public function getApprobation() {
		return $this->approbation;
	}
	
	public function setApprobation($approbation) {
		foreach ($approbation as $app)
			$app->setDateDemandeApprobation(new \DateTime());
		$this->approbation = $approbation;
		return $this;
	}
	
	
	public function signer(){
		global $kernel;
			if('AppCache'===get_class($kernel)){
				$kernel=$kernel->getKernel();
			}
		$rootDir=$kernel->getContainer()->getparameter('kernel.root_dir');
		$addr=$kernel->getContainer()->getparameter('sonata_media.cdn.host');
		$file=$rootDir.'/../web/'.$addr.'/'.$this->fichier->getName();
		$pdf= new \setasign\Fpdi\Fpdi();
		$pagecount= $pdf->setSourceFile($file);
		
		for($i=1;$i<=$pagecount;$i++){
			$tplid=$pdf->importPage($i);
			$size=$pdf->getTemplateSize($tplid);
			$pdf->AddPage($size['orientation']);
			
			$width=$size['width'];
			$heigth=$size['height'];
			$pdf->setFont('Arial','B');
			$pdf->useTemplate($tplid);
			$pdf->SetTextColor(255,0,0);
			$pdf->SetXY(($width-140)+1,($heigth-90)-2);
			$pdf->Write(8,'-----------------------------------------------------------------------');
			$pdf->SetXY(($width-140),($heigth-90));
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140)+100,($heigth-90));
			$pdf->Write(8,'|');
			
			$pdf->SetXY(($width-140),($heigth-90)+5);
			$pdf->Write(8,'|');
			
			$pdf->SetXY(($width-140)+32,($heigth-90)+5);
			$pdf->Write(8,'Total Réunion');		
			$pdf->SetXY(($width-140)+100,($heigth-90)+5);
			$pdf->Write(8,'|');
			
			
			
			$pdf->SetXY(($width-140)+2,($heigth-90)+7);
			$pdf->Write(8,'---------------------------------------------------------------------');
			$pdf->SetXY(($width-140)+100,($heigth-90)+7);
			
			
			$pdf->SetXY(($width-140)+2,($heigth-90)+15);
			$pdf->Write(8,'Approuvee par XXXXXXXXXXXX le jj/mm/aaa');
			$pdf->SetXY(($width-140)+100,($heigth-90)+15);
			
			$pdf->Write(8,'|');
			
			$pdf->SetXY(($width-140),($heigth-90)+10);
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140)+100,($heigth-90)+10);
			$pdf->Write(8,'|');
			
			

			$pdf->SetXY(($width-140),($heigth-90)+15);
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140)+100,($heigth-90)+15);
			
			
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140),($heigth-90)+20);
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140)+100,($heigth-90)+20);
			
			$pdf->Write(8,'|');					
			$pdf->SetXY(($width-140),($heigth-90)+25);
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140)+100,($heigth-90)+25);
			
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140),($heigth-90)+30);
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140)+100,($heigth-90)+30);
	
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140),($heigth-90)+35);
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140)+100,($heigth-90)+35);
			
			$pdf->Write(8,'|');
			
			$pdf->SetXY(($width-140),($heigth-90)+40);
			$pdf->Write(8,'|');
			$pdf->SetXY(($width-140)+100,($heigth-90)+40);			
			$pdf->Write(8,'|');
			
			$pdf->SetXY(($width-140)+1,($heigth-90)+42);
			$pdf->Write(8,'-----------------------------------------------------------------------');
		
			
		}
		//$tpl= new \Fpdi\FpdfTpl();
		
		
		
			//if($size['orientation']==='L')
			//	$pdf->useImportedPage($tplid,null,null,$size[1],$size[0]);
			//else 
				//$pdf->useImportedPage($tplid);//,null,null,$size['width'],$size['height']);
		
		$pdf->Output('F',$file);
		$pdf->Close();
		
		return $this;
	}
	public function getCommentairapprobation() {
		return $this->commentairapprobation;
	}
	public function setCommentairapprobation($commentairapprobation) {
		$this->commentairapprobation = $commentairapprobation;
		return $this;
	}
	public function getEtiquettes() {
		return $this->etiquettes;
	}
	public function setEtiquettes($etiquettes) {
		$this->etiquettes = $etiquettes;
		return $this;
	}
	public function getAffectationapprobation() {
		return $this->affectationapprobation;
	}
	public function setAffectationapprobation($affectationapprobation) {
		$this->affectationapprobation = $affectationapprobation;
		return $this;
	}
	
	
}
