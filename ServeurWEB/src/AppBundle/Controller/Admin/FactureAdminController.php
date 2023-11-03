<?php

namespace AppBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery as ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Facture;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;
use AppBundle\Entity\Action;
use Symfony\Component\Workflow\Workflow;

class FactureAdminController extends Controller
{   
    
	public function batchActionValide(ProxyQueryInterface $query)
    {
    	$em = $this->getDoctrine()->getEntityManager();

        foreach ($query->getQuery()->getResult() as $object) {
            $object->setCheckValide(true);
            $this->updatestatus($object);
            $em->persist($object);
            $em->flush();
            
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
	public function batchActionInvalide(ProxyQueryInterface $query)
    {
    	$em = $this->getDoctrine()->getEntityManager();

        foreach ($query->getQuery()->getResult() as $object) {
            $object->setCheckValide(false);
            $this->updatestatus($object);
            $em->persist($object);
            $em->flush();
            
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
	public function batchActionPaye(ProxyQueryInterface $query)
    {
    	$em = $this->getDoctrine()->getEntityManager();

        foreach ($query->getQuery()->getResult() as $object) {
            $object->setCheckPaye(true);
            $this->updatestatus($object);
            $em->persist($object);
            $em->flush();
            
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
	public function batchActionInpaye(ProxyQueryInterface $query)
    {
    	$em = $this->getDoctrine()->getEntityManager();

        foreach ($query->getQuery()->getResult() as $object) {
            $object->setCheckPaye(false);
            $this->updatestatus($object);
            $em->persist($object);
            $em->flush();
           
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
    private function updatestatus($facture){
    	
    	$workflow = new  \WorkflowBundle\Workflow\Workflow($this->get('logger'),$this->getDoctrine());
    	// On crée un objet Advert
    	$action=new Action();
    	if($facture->getStep()->getCode() === 'FACTOAPP'){
    		if($facture->getCheckapprouve()){
    			$ConnectedUser = $this->get('core.security')->getUser();
    			$facture->UserSetApprobation($ConnectedUser,$facture->getCheckapprouve());
    			if($facture->setNextApprobateur())
    				$this->AskApprobation($facture);
    				$this->signer($facture, $ConnectedUser,$facture->getRank($ConnectedUser));
    					
    		}else
    		{
    			//Envoie mail vers compta pour action car non approuvé
    			$this->refuseApprobation($facture);
    		}
    			
    			
    	}	    	
    	$facture->saveApprobation();
    	$stepDestination=$workflow->manageStatus($facture->getStep()->getCode(),$facture);
    	$facture->setCheckapprouve($facture->getAllapproved());
    	$action->setName('Modification');
    	$action->setUser($this->get('core.security')->getUser());
    	
    	
    	if($stepDestination!==null && $stepDestination->getCode() === 'FACTOAFF'){
    		$facture->setCreated(new \DateTime());
    		$facture->setDateEcheance($this->calculerDateEcheance($facture));
    	}
    	
    	if($stepDestination!==null && $stepDestination->getCode() === 'FACTOAPP'){
    		$facture->setNextApprobateur();
    		$this->AskApprobation($facture);
    	}
    	if($facture->getAllapproved() && $stepDestination!==null && $stepDestination->getCode() === 'FACTOWRI' && $facture->getStep()->getCode() === 'FACTOAPP')
    	{
    		$this->AccepteApprobation($facture);
    	}
    	if($facture->getCheckPaye() && $facture->getStep()->getCode() === 'FACTOPAY')
    	{
    		//$this->AskApprobation($facture->getNextApprobateur());
    	}
    		
    	$facture->addAction($action);
    }
    
    private function signer( $facture,  $user,$place){
    	global $kernel;
    	if('AppCache'===get_class($kernel)){
    		$kernel=$kernel->getKernel();
    	}
    	$rootDir=$kernel->getContainer()->getparameter('kernel.root_dir');
    	$addr=$kernel->getContainer()->getparameter('sonata_media.cdn.host');
    	$file=$rootDir.'/../web/'.$addr.'/'.$facture->getFichier()->getName();
    	$pdf= new \setasign\Fpdi\Fpdi();
    	$pagecount= $pdf->setSourceFile($file);
    
    	for($i=1;$i<=$pagecount;$i++){
    		$tplid=$pdf->importPage($i);
    		$size=$pdf->getTemplateSize($tplid);
    		$pdf->AddPage($size['orientation']);
    			
    		$width=$size['width']+60;
    		$heigth=110;
    		$pdf->setFont('Times','',8);
    		$pdf->useTemplate($tplid);
    		$pdf->SetTextColor(255,0,0);
    		$pdf->SetDrawColor(255,0,0);
    		if($place===0){
    
    				
    			$pdf->SetXY(($width-140)+1,($heigth-90)-2);
    			$pdf->Rect(($width-140)+1, ($heigth-90), 70, 40);

    
    			$pdf->SetXY(($width-140)+25,($heigth-90)+1);
    			$pdf->Write(8,'Total Reunion');
 
    				
    			$pdf->line(($width-140)+1,($heigth-90)+7,($width-140)+71,($heigth-90)+7);

    
    			$pdf->SetXY(($width-140)+2,($heigth-90)+6);
    			$pdf->SetTextColor(51,102,204);
    			$now=new \DateTime();
    			$pdf->Write(8,'Approuvee par '.$user->getUsername().' le '.($now->format('Y-m-d')));
    			$pdf->SetTextColor(255,0,0);
    			
    		}else{
    			$now=new \DateTime();
    			$pdf->SetXY(($width-140)+2,($heigth-90)+6+(4*$place));
    			$pdf->SetTextColor(51,102,204);
    			$pdf->Write(8,'Approuvee par '.$user->getUsername().' le '.($now->format('Y-m-d H:i:s')));
    			$pdf->SetTextColor(255,0,0);    				
    		}   
    	}
    	$pdf->Output('F',$file);
    	//$pdf->Output();
    	$pdf->Close();
    
    	return $this;
    }
    
    
    private function AskApprobation($facture){
    	$this->get('logger')->info("Traitement demande approbation");
    	//$url=$this->getConfigurationPool()->getContainer()->get('router')->generate('admin_app_factureaapprouver_edit', array('id' => $facture->getId()));
    	$message=$this->get('templating')
    	->render('Ask_approbation.html.twig',array('nfacture' => $facture->getName(),'prenom' =>$facture->getApprobateur()->getFirstname(),'id' => $facture->getId()));
    	$object='Demande d\'approbation';
    	$this->sendRedictedmail($message,$object,$facture->getApprobateur()->getEmail());
    }
    
    
    private function refuseApprobation($facture){
    	$this->get('logger')->info("refus approbation");
    	//$url=$this->getConfigurationPool()->getContainer()->get('router')->generate('admin_app_factureasaisir_edit', array('id' => $facture->getId()));
    
    
    	$message=$this->get('templating')
    	->render('refuse_approbation.html.twig',array('nfacture' => $facture->getName(),'prenom' =>$facture->getAffectation()->getFirstname(),'id' => $facture->getId()));
    	$object='Refus d\'approbation';
    	$this->sendRedictedmail($message,$object,$facture->getAffectation()->getEmail());
    }
    
    private function sendMail($dest,$message,$object){
    	$this->get('logger')->info("Envoie mail à : ".$dest." - contenu: ".$message);
    	$mime_message = (new \Swift_Message($object))->setFrom($this->utilisateur)->setTo($dest)->setBody($message,"text/html");
    	$this->get('mailer')->send($mime_message);
    }
    
    
    private function sendRedictedmail($message,$object,$to){
    	
    	$modDev=$this->container->getParameter('mod_dev');
    	$addrDev=$this->container->getParameter('addr_dev');
    	if($modDev)
    		$this->sendMail($addrDev,$message,$object);
    		else {
    			$this->sendMail($to,$message,$object);
    		}
    }
	
}
