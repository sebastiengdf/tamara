<?php

namespace AppBundle\Twig;

use CoreBundle\Entity\Traits\Containerable;

class FactureTwig extends \Twig_Extension
{
	use Containerable;
    protected $factureManager;
	protected $servicecontainer;

    public function __construct(\AppBundle\Manager\FactureManager $factureManager,$container)
    {
        $this->factureManager = $factureManager;
        $this->servicecontainer=$container;
    }
    

	public function getFacture()
    {
        return $this->factureManager->getRepository()->findBy(
        	array(),
        	array('created' => 'desc'),
        	10,
        	0
        );
    }

    public function getFacturePaye()
    {
        return $this->factureManager->getFacturePaye();
    }
    
	public function getFactureValide()
    {
        return $this->factureManager->getFactureValide();
    }
    
	public function getNbFacture()
    {
        return sizeof($this->factureManager->getRepository()->findAll());
    }
    
	public function getNbFacturePaye()
    {
        return sizeof($this->factureManager->getRepository()->findBy(['check_paye' => true]));
    }
    
	public function getNbFactureValide()
    {
        return sizeof($this->factureManager->getRepository()->findBy(['check_valide' => true]));
    }
    
    public function getNbGranted(){
    	$nb= 0+ ($this->securityAsGrantedAcces('ROLE_APP_ADMIN_FACTUREENERREUR_ALL')?$this->getNbEnErreur():0)
    	//+ ($this->securityAsGrantedAcces('ROLE_APP_ADMIN_FACTUREPAYE_ALL')?$this->getNbFacturePaye():0)
    	+ ($this->securityAsGrantedAcces(' ')?$this->getNbFactureValide():0)
    	+ ($this->securityAsGrantedAcces('ROLE_APP_ADMIN_FACTUREAAFFECTER_ALL')?$this->getNbaAffecter():0)
    	+ ($this->securityAsGrantedAcces('ROLE_APP_ADMIN_FACTUREAAPPROUVER_ALL')?$this->getNbaApprouver():0)
    	+ ($this->securityAsGrantedAcces('ROLE_APP_ADMIN_FACTUREASAISIR_ALL')?$this->getNbasaisir():0)
    	+ ($this->securityAsGrantedAcces('ROLE_APP_ADMIN_FACTUREATTENTEBC_ALL')?$this->getNbattentebc():0)
    	+ ($this->securityAsGrantedAcces('ROLE_APP_ADMIN_FACTUREAVALIDER_ALL')?$this->getNbaValider():0)
    	+ ($this->securityAsGrantedAcces('ROLE_APP_ADMIN_FACTUREAPAYER_ALL')?$this->getNbaPayer():0);
    	return $nb;
    }
    
    public function securityAsGrantedAcces($rolename){
    	$ConnectedUser=$this->servicecontainer->get('core.security')->getUser();
	    	$Groupes = $ConnectedUser->getGroups();
	    	if($Groupes!==null)
	    		foreach ($Groupes as $groupe){
	    	//	if('super administrateur'===strtolower($groupe->getName()))
	    		//		return true;
	    			$roles=$groupe->getRoles();
	    			foreach ($roles as $role){
	    			if(strtolower($rolename) === strtolower($role))
	    				return true;
	    			}
	    	}
    	return false;
    }
    public function pathIsdefined($path){
    	$router=$this->container->get('router');
    	return (null===$router->getRouteCollection()->get($path))?false:true;
    }
    	
    public function getNbEnErreur() {
    	
    	$qb=$this->factureManager->getRepository()
    			->createQueryBuilder('o')    			
    			->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    			->setParameter('statut', 'FACERR');    			
    	return  sizeof($qb->getQuery()->getResult());
    }
    
    public function getNbaAffecter() { 
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->setParameter('statut', 'FACTOAFF');
    	return  sizeof($qb->getQuery()->getResult());
    }
 
    public function getNbaApprouver() {
    	$ConnectedUser = $this->servicecontainer->get('core.security')->getUser();
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->setParameter('statut', 'FACTOAPP')
    	->where('o.approbateur = :approbateur')
    	//->Andwhere('o.approbation', 'approbation', 'with','approbateur = :approbateur and approbation.approuve = :approuve')
    	//->addSelect('approbation')
    	->setParameter('approbateur', $ConnectedUser->getId());
    	//->setParameter('approuve',false);
    	return  sizeof($qb->getQuery()->getResult());
    }
    
    
    public function getNbaApprouverAll() {
    	$ConnectedUser = $this->servicecontainer->get('core.security')->getUser();
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->setParameter('statut', 'FACTOAPP')
    	->innerJoin('o.approbation', 'approbation', 'with','approbation.approuve = :approuve')
    	//->addSelect('approbation')
    	//->setParameter('approbateur', $ConnectedUser->getId())
    	->setParameter('approuve',false);
    	return  sizeof($qb->getQuery()->getResult());
    }
    public function getNbattentebc() {
    	$ConnectedUser = $this->servicecontainer->get('core.security')->getUser();
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->innerJoin('o.affectationapprobation', 'user', 'with','user.id = :user')
    	->setParameter('statut', 'FACTOWAITBC')	
    	->setParameter('user', $ConnectedUser->getId());
    	
    	return  sizeof($qb->getQuery()->getResult());
    }
    
    public function getNbattentebcAll() {
    	//$ConnectedUser = $this->servicecontainer->get('core.security')->getUser();
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->leftJoin('o.affectationapprobation', 'user')
    	->setParameter('statut', 'FACTOWAITBC');
    /*	$qb->where(modalwindow
    			$qb->expr()->orX(
    					$qb->expr()->isNull('user.id'),
    					$qb->expr()->eq('user', $ConnectedUser->getId())
    					)
    			);
    	 */
    	return  sizeof($qb->getQuery()->getResult());
    }
    public function getNbasaisir() {
    	$ConnectedUser = $this->servicecontainer->get('core.security')->getUser();
    	$Groupes = $ConnectedUser->getGroups();
    	$isChefcomptable=false;
    	if($Groupes!==null)
    		foreach ($Groupes as $groupe){
    			$droit = strtolower($groupe->getName());
    			if($droit == "chef comptable")
    				$isChefcomptable=true;
    				 
    	}
    	
    	
    	
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->setParameter('statut', 'FACTOWRI');
    	if(!$isChefcomptable){
    		$qb->innerJoin('o.affectation', 'affectation', 'with','affectation.id = :user')->addSelect('affectation')
    		->setParameter('user', $ConnectedUser->getId());
    	}
    	return  sizeof($qb->getQuery()->getResult());
    	
    }
    
    
    public function getNbagerer() {
        $ConnectedUser = $this->servicecontainer->get('core.security')->getUser();
        $Groupes = $ConnectedUser->getGroups();
        $isChefcomptable=false;
        if($Groupes!==null)
            foreach ($Groupes as $groupe){
                $droit = strtolower($groupe->getName());
                if($droit == "chef comptable")
                    $isChefcomptable=true;
                    
        }
        
        
        $qb=$this->factureManager->getRepository()
        ->createQueryBuilder('o')
        ->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
        ->setParameter('statut', 'FACTTOMAN');
        if(!$isChefcomptable){
            $qb->innerJoin('o.affectation', 'affectation', 'with','affectation.id = :user')->addSelect('affectation')
            ->setParameter('user', $ConnectedUser->getId());
        }
        return  sizeof($qb->getQuery()->getResult());
        
    }
    
    
    public function getNbenlitige() {
        $ConnectedUser = $this->servicecontainer->get('core.security')->getUser();
        $Groupes = $ConnectedUser->getGroups();
        $isChefcomptable=false;
        if($Groupes!==null)
            foreach ($Groupes as $groupe){
                $droit = strtolower($groupe->getName());
                if($droit == "chef comptable")
                    $isChefcomptable=true;
                    
        }
        
        $qb=$this->factureManager->getRepository()
        ->createQueryBuilder('o')
        ->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
        ->setParameter('statut', 'FACTINLI');
        if(!$isChefcomptable){
            $qb->innerJoin('o.affectation', 'affectation', 'with','affectation.id = :user')->addSelect('affectation')
            ->setParameter('user', $ConnectedUser->getId());
        }
        return  sizeof($qb->getQuery()->getResult());
        
    }

   
    public function getNbagererAll() {
        
        $qb=$this->factureManager->getRepository()
        ->createQueryBuilder('o')
        ->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
        ->setParameter('statut', 'FACTTOMAN');
        
        return  sizeof($qb->getQuery()->getResult());
        
    }
    
    
    public function getNbenlitigeAll() {
        
        $qb=$this->factureManager->getRepository()
        ->createQueryBuilder('o')
        ->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
        ->setParameter('statut', 'FACTINLI');
        
        return  sizeof($qb->getQuery()->getResult());
        
    }
    public function getNbasaisirAll() {
    	    	 
    	//$ConnectedUser = $this->servicecontainer->get('core.security')->getUser();
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->setParameter('statut', 'FACTOWRI');
    	/*if(!$isChefcomptable){
    		$qb->innerJoin('o.affectation', 'affectation', 'with','affectation.id = :user')->addSelect('affectation')
    		->setParameter('user', $ConnectedUser->getId());
    	}*/
    	return  sizeof($qb->getQuery()->getResult());
    	 
    }
    public function getNbaValider() {
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->setParameter('statut', 'FACTOVAL');
    	return  sizeof($qb->getQuery()->getResult());
    }
    public function getNbaPayer() {
    	$qb=$this->factureManager->getRepository()
    	->createQueryBuilder('o')
    	->innerJoin('o.step','step', 'WITH' , 'step.code = :statut')->addSelect('step')
    	->setParameter('statut', 'FACTOPAY');
    	return  sizeof($qb->getQuery()->getResult());
    }
    public function getFunctions()
    {
    
        return array(
        	'getFacture' => new \Twig_Function_Method($this, 'getFacture'),
            'getFacturePaye' => new \Twig_Function_Method($this, 'getFacturePaye'),
        	'getFactureValide' => new \Twig_Function_Method($this, 'getFactureValide'),
        	'getNbFacture' => new \Twig_Function_Method($this, 'getNbFacture'),
        	'getNbFacturePaye' => new \Twig_Function_Method($this, 'getNbFacturePaye'),
        	'getNbFactureValide' => new \Twig_Function_Method($this, 'getNbFactureValide'),
        	'getNbEnErreur' => new \Twig_Function_Method($this, 'getNbEnErreur'),
        	'getNbaAffecter' => new \Twig_Function_Method($this, 'getNbaAffecter'),
        	'getNbaApprouver' => new \Twig_Function_Method($this, 'getNbaApprouver'),
        	'getNbattentebc' => new \Twig_Function_Method($this, 'getNbattentebc'),
        	'getNbaValider' => new \Twig_Function_Method($this, 'getNbaValider'),
        	'getNbaPayer' => new \Twig_Function_Method($this, 'getNbaPayer'),
        	'getNbasaisir' => new \Twig_Function_Method($this, 'getNbasaisir'),
        	'securityAsGrantedAcces' => new \Twig_Function_Method($this, 'securityAsGrantedAcces',array('$rolename')),
        	'pathIsdefined' => new \Twig_Function_Method($this, 'pathIsdefined',array('$path')),
        	'getNbGranted' => new \Twig_Function_Method($this, 'getNbGranted',array('$path')),
        	'getNbaApprouverAll' => new \Twig_Function_Method($this, 'getNbaApprouverAll',array('$path')),
        	'getNbattentebcAll' => new \Twig_Function_Method($this, 'getNbattentebcAll'),
        	'getNbasaisirAll' => new \Twig_Function_Method($this, 'getNbasaisirAll'),
            
            'getNbagerer' => new \Twig_Function_Method($this, 'getNbagerer'),
            'getNbenlitige' => new \Twig_Function_Method($this, 'getNbenlitige'),
            'getNbagererAll' => new \Twig_Function_Method($this, 'getNbagererAll'),
            'getNbenlitigeAll' => new \Twig_Function_Method($this, 'getNbenlitigeAll'),
        		
        );
    }

    public function getName()
    {
       return 'factureTwig';
    }
}