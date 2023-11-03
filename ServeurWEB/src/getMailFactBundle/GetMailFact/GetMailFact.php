<?php

namespace getMailFactBundle\GetMailFact;
use AppBundle\Entity\Facture;
use CoreBundle\Entity\Fichier;
use AppBundle\Entity\Bon_livraison;
use Doctrine\Common\Persistence\ManagerRegistry;
use CmsBundle\Entity\File;
use Monolog\Logger;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\ORM\NoResultException;
use getMailFactBundle\Entity\Status;
use getMailFactBundle\GetMailFact\BonLivraisonMail;
use getMailFactBundle\GetMailFact\FactureMail;
use AppBundle\Entity\Fournisseur;
use WorkflowBundle\Workflow\Workflow;
use WorkflowBundle\Entity\WorkflowStep;
use \Datetime;
class GetMailFact {
	private $utilisateur;
	private $password;
	private $serveurImapAddr;
	private $ssl;
	private $timout;
	private $imap;
	private $uidReferencing;
	private $doctrine;
	private $filemedia;
	private $logger;
	private $nbmailMax;
	private $mailer;
	private $twig;
	private $workflow;
	private $modDev;
	private $addrDev;
	private $addrAgentsTotal;
	function __construct(
			\Swift_Mailer $mailer,
			$utilisateur,
			$password,
			$serveurImapAddr,
			$ssl,
			$timout,
			$uidReferencing,
			ManagerRegistry $doctrine,
			$filemedia,
			$logger,
			$nbmailMax,
			$isredirection,
			\Twig_Environment $twig,
			\WorkflowBundle\Workflow\Workflow $workflow,
			$modDev,
			$addrDev,
			$addrAgentsTotal
			){
		$this->mailer=$mailer;
		$this->utilisateur=$utilisateur;
		$this->password=$password;
		$this->serveurImapAddr=$serveurImapAddr;
		$this->ssl=$ssl;
		$this->timout=$timout;
		$this->uidReferencing=$uidReferencing;
		$this->filemedia=$filemedia;
		$this->nbmailMax=$nbmailMax;
		$this->doctrine=$doctrine;
		$this->logger=$logger;
		$this->isredirection=$isredirection;
		$this->twig=$twig;
		$this->workflow=$workflow;
		$this->modDev=$modDev;
		$this->addrDev=$addrDev;
		$this->addrAgentsTotal=$addrAgentsTotal;
	}
	private $from;
	private $subject;
	private $isredirection;
	public function integrateInvoice(){
		$options = new \ezcMailImapTransportOptions();
		$this->logger->info('Connection boite mail');
		$options->ssl = $this->ssl;
		$this->logger->info('Connection SSL: '.$this->ssl);
		$options->timeout=$this->timout;
		$this->logger->info('Connection TIMOUT: '.$this->timout);
		$options->uidReferencing = true;
		$server=$this->serveurImapAddr;
		$this->logger->info('Adresse Serveur: '.$this->serveurImapAddr);
		$this->logger->info('NbmailMax: '.$this->nbmailMax);
		
		$this->imap= new \ezcMailImapTransport($server, null, $options );
	
		// Authenticate to the IMAP server
		$this->imap->authenticate( $this->utilisateur, $this->password);
		$this->logger->info('Connexion effectuée => Utilisateur: '.$this->utilisateur);
		$this->imap->selectMailbox( 'Inbox' );
		$messages = $this->imap->listUniqueIdentifiers();
		for ( $cnt = 0; $cnt < $this->nbmailMax; $cnt++ )
		{		
				end($messages);
				$enid=key($messages);
				if($enid===null)
					return;
				$uniqId=$messages[$enid];
				unset($messages[$enid]);
				$set = $this->imap->fetchByMessageNr( $uniqId );
				$parser = new \ezcMailParser();
				$mail = $parser->parseMail( $set);								
				for ( $i = 0; $i < count( $mail ); $i++ )
				{
					$parts = $mail[$i]->fetchParts();
					$this->from=$mail[$i]->from->email;
					$this->subject=$mail[$i]->subject;
					$this->logger->info('Détection mail : '.$this->subject." - idmail: ".$uniqId." - from: ".$this->from);
					$facture=null;
					$bl=null;
					$bls=[];
					$factures=[];
					$return=null;
					try{
						foreach ( $parts as $part )
						{
							if (strcmp( get_class($part) , "ezcMailFile")==0 ){
								$nomFichier=basename( $part->contentDisposition->displayFileName );
								$path_parts = pathinfo($nomFichier);
								if(strtolower($path_parts['extension']) != "pdf"){
									$this->logger->info($nomFichier." Non PDF : Continue");
									continue;
								}
							}
							$file=$this->setFile($part);
							$facture=$this->setFacture($part);
							if($facture != null)
							{
								$this->logger->info("Insertion Facture dans le tableau". count($factures));
								$facture->getfacture()->setFichier($file);
								$factures[] = $facture;
								$this->logger->info("Insertion Facture dans le tableau terminé ". count($factures));
								/*if(count($factures)>0)
									array_push($factures,$facture);
								else 
									$factures=array($facture);*/
								
							}else{
								$bl=$this->setBL($part,$return);
								if($bl != null)
								{
									$this->logger->info("Insertion BL dans le tableau". count($bls));
									$bl->getBonlivraison()->setFichier($file);
									$bls[] = $bl;
									$this->logger->info("Insertion BL dans le tableau terminé ". count($bls));
									/*if(count($bls)>0)
										array_push($bls,$bl);
									else
										$bls=array($bl);	*/						
								}
							}
						}	
						$this->logger->info("Nombre Factures trouvees : ".count($factures));
						$this->logger->info("Nombre Bls trouvees : ".count($bls));
						if(count($factures)>0)
						{
							$this->logger->info("BEN 1");
							$this->associer($factures, $bls);
							//$this->deleteMail($uniqId);
						}elseif(count($factures)==0){
								$this->logger->info("BEN 2");
								if(count($bls)!=0){
									$this->logger->info("BEN 3");
									$factures=$this->rechercheFactureByBl($bls);
									if(count($factures)==0){
										$this->manageBadFormatInvoice();
									}else{
										$this->logger->info("BEN 4");
										$this->associer($factures, $bls);
									}
								}else{				
									$this->manageBadFormatInvoice();
								}
						}
					}catch (Exception $ex){
						$this->logger->error($ex->getMessage().":".$ex->getTraceAsString());
					

						//BAD FORMAT INVOICE
						if(strcmp($ex->getMessage(),"BAD FORMAT INVOICE")==0)
							$this->manageBadFormatInvoice();
						
						if(strcmp($ex->getMessage(),"BAD DATE FORMAT INVOICE")==0)
							$this->manageBadDateInvoice($facture);
						//BAD FORMAT BL
						if(strcmp($ex->getMessage(),"BAD FORMAT BL")==0)
							$this->manageBadFormatBL();
						//BAD FOURNISSEUR BL
						if(strcmp($ex->getMessage(),"BAD FOURNISSEUR BL")==0)
							$this->manageBadProviderBL($facture);
						//BAD DATE FORMAT BL
						if(strcmp($ex->getMessage(),"BAD DATE FORMAT BL")==0)
							$this->manageBadDateBL();
					}
				}
				$this->deleteMail($uniqId);
		}
	}
	
	private function rechercheFactureByBl($bls){
		$this->logger->info("recherche facture By BL");
		$factures=null;
		foreach ($bls as $bl){	
			$this->logger->info("Bonde de livraison n° ".$bl->getBonlivraison()->getName()." existe?");
			$facture=$this->getFacturebyCode($bl->getBonlivraison()->getName());
			if($facture!==null)
			{
				$this->logger->info("Facture n° ".$facture->getName()." trouvée");
				$factureM=new FactureMail($facture);
			if(!is_null($factures))
				array_push($factures,$factureM);
				else
					$factures=array($factureM);
			}
			else 
				$this->manageBadFormatBLByname($bl->getBonlivraison()->getName());
		}
		return $factures;
		
	}
	private function sendMail($dest,$message,$object){
		$this->logger->info("Envoie mail à : ".$dest." - contenu: ".$message);
		$mime_message = (new \Swift_Message($object))->setFrom($this->utilisateur)->setTo($dest)->setBody($message,"text/html");
		$this->mailer->send($mime_message);
	}

	
	private function sendRedictedmail($message,$object){
		if($this->modDev)
			$this->sendMail($this->addrDev,$message,$object);
		else {
			if($this->isredirection)
				$this->sendMail(getSenderfromSubject($this->subject),$message,$object);
			else
				$this->sendMail($this->from,$message,$object);
		}
	}

	private function getSenderfromSubject($subject){
		$subject='';
		
		return $subject;
	}
	
	// SUCCESS INVOICE
	private function InvoiceSucces(FactureMail $facture){
		// SEND MAIL TO SENDER AND SET STEP
		$this->logger->info("Traitement de facture traitée avec succès");
		$this->setFactureToStatus($facture,$this->getStatusByCode("FACTOVAL"));
		$this->setFactureToStep($facture,$this->getStepByCode("FACTOAFF"));
		$message=$this->twig->render('getmailFact\Good_mail.html.twig',array('name'=>$facture->getfacture()->getName()));
		$object='La remise de votre document n°'.$facture->getfacture()->getName().' a été traitée avec succès';
		$this->sendRedictedmail($message,$object);

		// SEND DATAS TO PROVIDERS
		$this->logger->info("Envoi de la facture aux fournisseurs");
		$message=$this->twig->render('getmailFact\Provider_mail.html.twig',array('name'=>$facture->getfacture()->getName()));
		$object='Réception du document n°'.$facture->getfacture()->getName().'.';
		$attachment = \Swift_Attachment::fromPath($facture->getfacture()->getFichier()->getFile()->getPath().'/'.$facture->getfacture()->getFichier()->getFile()->getFilename());
		$provider_message = (new \Swift_Message($object))->setFrom($this->utilisateur)->setTo($this->addrAgentsTotal)->setBody($message,"text/html")->attach($attachment);
		$this->mailer->send($provider_message);
	}
	
	//BAD FORMAT INVOICE
	private function manageBadFormatInvoice(){
		$this->logger->info("Traitement du mauvais format de facture.");
		$message=$this->twig->render('getMailFact\Bad_mail.html.twig');
		
		$object='La remise de votre document n\'a pas pu être traitée';
		$this->sendRedictedmail($message,$object);
	}
	//BAD FOURNISSEUR INVOICE
	private function manageBadProviderInvoice($facture){
		$this->logger->info("Traitement du mauvais fournisseur d'image");
		$this->setFactureToStatus($facture,$this->getStatusByCode("FACERR"));
		$this->setFactureToStep($facture,$this->getStepByCode("FACERR"));
		//$twig=new \Twig_Environment(new \Twig_Loader_Array(array('getMailFactBundle:Bad_mail.html.twig')));
		$message=$this->twig->render('getMailFact\Bad_mail.html.twig');
		
		$object='La remise de votre document n\'a pas pu être traitée';
		$this->sendRedictedmail($message,$object);
	}
	//BAD DATE FORMAT INVOICE
	private function manageBadDateInvoice($facture){
		$this->logger->info("Traitement de mauvaise date");
		$this->setFactureToStatus($facture,$this->getStatusByCode("FACERR"));
		$this->setFactureToStep($facture,$this->getStepByCode("FACERR"));
		//$twig=new \Twig_Environment(new \Twig_Loader_Array(array('base.html.twig')));
		$message=$this->twig->render('getMailFact\Bad_mail.html.twig');
		
		$object='La remise de votre document n\'a pas pu être traitée';
		$this->sendRedictedmail($message,$object);
	}
	//BAD FORMAT BL
	private function manageBadFormatBL(){
		$this->logger->info("Traitement du mauvais format de bon de livraison");
		//$twig=new \Twig_Environment(new \Twig_Loader_Array(array('getMailFactBundle:Bad_mail.html.twig')));
		$message=$this->twig->render('getMailFact\Bad_mail.html.twig');
		$object='La remise de votre document n\'a pas pu être traitée';
		$this->sendRedictedmail($message,$object);
	}
	
	private function manageBadFormatBLByname($name){
		$this->logger->info("Traitement du mauvais format de bon de livraison");
		//$twig=new \Twig_Environment(new \Twig_Loader_Array(array('getMailFactBundle:Bad_mail.html.twig')));
		$message=$this->twig->render('getMailFact\Bad_mail.html.twig');
		$object='La remise de votre bon de livraison n°: '.$name.' n\'a pas pu être traitée';
		$this->sendRedictedmail($message,$object);
	}
	
	//BAD FOURNISSEUR BL
	private function manageBadProviderBL( $facture){
		$this->logger->info("Traitement du mauvais fournisseur");
		$this->setFactureToStatus($facture,$this->getStatusByCode("FACERR"));
		$this->setFactureToStep($facture,$this->getStepByCode("FACERR"));
		//$twig=new \Twig_Environment(new \Twig_Loader_Array(array('getMailFactBundle:Bad_mail.html.twig')));
		$message=$this->twig->render('getMailFact\Bad_mail.html.twig');	
		
		$object='La remise de votre document n\'a pas pu être traitée';
		$this->sendRedictedmail($message,$object);
		
		//Mise à jour facture en erreur
	
	}

	// Calcul de la date d'échéance	
	private function calculerDateEcheance(Facturemail $facture){
		$date = new DateTime();
		$dernierJourMois = $date -> format('t-m-Y');
		$fournisseurDelai = $facture->getfacture()->getFournisseur()->getDelaiDateEcheance();
		$dateStr = date('d-m-Y',strtotime("+$fournisseurDelai days", strtotime($dernierJourMois)));
		$dateEcheance = date_create_from_format('d-m-Y', $dateStr);
		$dateEcheance->setTime(0, 0, 0, 0);
		return $dateEcheance;
	}

	private function setFactureToStatus(FactureMail $facture, Status $status){
		//$status->
		if($facture!=null && $status!=null){
			/*$stausofFact = new StatusOfFacture();
			$stausofFact->setDate(new \DateTime());
			$stausofFact->setStatus($status);*/
			$facture->getfacture()->setCreated(new \DateTime());
			//$stausofFact->setFacture($facture->getfacture());
			$facture->getfacture()->setStatusf($status);
			$this->logger->info('Mise à jour status facture: '.$status->getLibelle());
			// Si facture bien reçue, ajout de la date d'échéance
			if(strcmp($status->getCode(),'FACTOVAL')==0){
				$facture->getfacture()->setDateEcheance($this->calculerDateEcheance($facture));
			}
			$em=$this->doctrine->getManager();
			$em->persist($facture->getfacture());
			//$statusS=$facture->getfacture()->setStatus($status);
			//foreach ($statusS as $status)
			//	$em->persist($status);
			$em->flush();
		}
	}

	private function setFactureToStep(FactureMail $facture, WorkflowStep $step){
		// On initialise Step
		$facture->getfacture()->setStep($this->getStepByCode("INIT"));
		if($facture!=null && $step!=null){
			$facture->getfacture()->setCreated(new \DateTime());
			// On utilise le workflow pour changer d'état
			$this->workflow->setDocument($facture->getfacture());
			$this->workflow->toStep($step);
			$this->logger->info('Mise à jour step facture: '.$step->getLibelle());
			// Si facture bien reçue, ajout de la date d'échéance
			if(strcmp($step->getCode(),'FACTOAFF')==0){
				$facture->getfacture()->setDateEcheance($this->calculerDateEcheance($facture));
			}
			$em=$this->doctrine->getManager();
			$em->persist($facture->getfacture());
			$em->flush();
		}
	}
	
	private function getFacturebyCode($num){
		try{
			$this->logger->info('Facture: '.$num.' existante?');
			$em=$this->doctrine->getManager();
			$query=$em->createQuery("select a from AppBundle:Facture a where replace(upper(a.name),' ','') = :name");
			$query->setParameter('name', strtoupper($num));
			$factures=$query->getResult();
			if(count($factures)>0)
				$this->logger->info('Facture numéro : '.$num.' trouvée');
			else 
			{
				$this->logger->info('Facture numéro : '.$num.' inconnue');
				return null;						
			}
			foreach ($factures as $facture)
				return $facture;
		}catch (NoResultException $e){$this->logger->info('Facture numéro : '.$num.' inconnue');
		return null;}
	}
	private function getStatusByCode($code){
		try{
			$this->logger->info('Status: '.$code.' existant?');
			$em=$this->doctrine->getManager();
			$query=$em->createQuery("select a from getMailFactBundle:status a where replace(upper(a.code),' ','') = :code");
			$query->setParameter('code', strtoupper($code));
			$status=$query->getSingleResult();
			$this->logger->info('Code: '.$code.' trouvé');
			return $status;
		}catch (NoResultException $e){$this->logger->info('Code: '.$code.' inconnu');
		return null;}
	}

	private function getStepByCode($code){
		try{
			$this->logger->info('Status: '.$code.' existant?');
			$em=$this->doctrine->getManager();
			$query=$em->createQuery("select a from WorkflowBundle:WorkflowStep a where replace(upper(a.code),' ','') = :code");
			$query->setParameter('code', strtoupper($code));
			$status=$query->getSingleResult();
			$this->logger->info('Code: '.$code.' trouvé');
			$this->logger->info('Code: '.$status->getLibelle().' trouvé');
			return $status;
		}catch (NoResultException $e){$this->logger->info('Code: '.$code.' inconnu');
		return null;}
	}
	
	//BAD DATE FORMAT BL
	private function manageBadDateBL(){
		$this->logger->info("Traitement du mauvais format de date de bon de livraison");	
		
		$message='';
		$object='';
		$this->sendRedictedmail($message,$object);
	}
	
	private function saveFacture(Facture $facture){
		$this->logger->info('Enregistrement facture n°: '.$facture->getName());
		$em=$this->doctrine->getManager();
		$em->persist($facture);
		$em->flush();
		
	}
	
	private function associer(&$factures,$bls){
		$nbajout=0;
		$haveBLBadDAte=false;
		$haveBLBadProvider=false;
		$haveFACTBadProvider=false;
		$haveFACTBadDate=false;
		$haveBLAllBad=false;
		foreach ($factures as $facture){
			$etatFAC=$facture->getEtat();
			if(strcmp($etatFAC,"BAD FOURNISSEUR INVOICE")==0)
				$haveFACTBadProvider=true;
			
			if(strcmp($etatFAC,"BAD DATE FORMAT INVOICE")==0)
				$haveFACTBadDate=true;
			if($bls!== null)	
			foreach ($bls as $bl){
				$this->logger->info('BEN 7');
				$numbl=$bl->getBonlivraison()->getName();
				$numfact=$facture->getfacture()->getName();
				$etatBl=$bl->getEtat();
				
				if(strcmp($etatBl,"BAD FORMAT BL")==0)
					$haveBLAllBad=true;
				if(strcmp($etatBl,"BAD FOURNISSEUR BL")==0)
					$haveBLBadProvider=true;
				if(strcmp($etatBl,"BAD DATE FORMAT BL")==0)
					$haveBLBadDAte=true;
				if(strcmp($numbl , $numfact )==0)
				{
					$facture->getfacture()->addBonLivraison($bl->getBonlivraison());
					$this->logger->info('Ajout bon de livraison à Facture n°: '.$facture->getfacture()->getName());
					$nbajout++;
				}
			}
			if($haveBLBadProvider)
				$this->manageBadProviderBL($facture);
		}

		
		if($haveFACTBadProvider){
			$this->manageBadProviderInvoice($facture);

		}else if($haveFACTBadDate){
			$this->manageBadDateInvoice($facture);
				
		}else if(!($nbajout=count($bls))){
			//$this->logger->info('BEN 10');
			//throw new Exception("BL affecté(s) manquant(s)")
                        $this->logger->error("BL affecté(s) manquant(s)");
                        foreach ($factures as $facture)
                                $this->InvoiceSucces($facture);


		
		}else{
			$this->logger->info('BEN 11');
			foreach ($factures as $facture)
				$this->InvoiceSucces($facture);
		}
	}
	private function generateFoldername(&$foldername, &$pathname){
		$rand= rand(10,10000);
		$dt=date("His");
		$foldername=$dt.$rand;
		$pathname=getcwd().$this->filemedia."/".$foldername."/";
		if(!is_dir($pathname))
			mkdir($pathname);

	}
	
	private function getFilename(\ezcMailPart $part){
		$filename='';
		if (strcmp( get_class($part) , "ezcMailFile")==0 )
			$filename=basename( $part->contentDisposition->displayFileName );
			return $filename;
	}
	
	private function deleteMail( $idmail){	
		$this->logger->info('Suppression mail n°: '.$idmail);
		$this->imap->delete($idmail);
		$this->imap->expunge();		
	}
	
	private function setFacture(\ezcMailPart $part){
	
		if ( strcmp(get_class($part) , "ezcMailFile" )==0)
		{
			$filename=$this->getFilename( $part );
			$this->logger->info('setFacture.filename: '.$filename);
			$facture=$this->generateFacture($filename);
			return $facture;
		}
		 
	}
	
	private function setBL(\ezcMailPart $part,&$return){
	
		if ( strcmp(get_class($part) , "ezcMailFile" )==0)
		{
			$filename=$this->getFilename( $part );
			$facture=$this->generateBL($filename,$return);
			return $facture;
		}
			
	}
	 
	private function setFile(\ezcMailPart $part){
		if ( strcmp(get_class($part), "ezcMailFile")==0 )
		{
			$filename=$this->getFilename( $part );
			$fichier=$this->generateFile($filename,$part);
			return $fichier;
		}
		 
	}
	
	private function saveFile(\CoreBundle\Entity\Fichier $fichier,\ezcMailFile $part){
		
			rename( $part->fileName, $fichier->getFile()->getPath().'/'.$fichier->getFile()->getFilename());
		
	}
	
	private function generateFacture($filename){
		$array=explode("_",$filename);
		$nb=count($array);
		if($nb==4){
			$typedoc=strtoupper($array[0]);
			$nomfournisseur=$array[1];
			$numerodocument=$array[2];
			$date=explode(".",$array[3])[0];
			
			if(strcmp($typedoc,"FACTURE")==0){
					$this->logger->info('Facture n°: '.$numerodocument.' détectée');
					//Recherche si facture déja existante
					$facture=null;
					$factureexist=$this->getFacturebyCode($numerodocument);
					if($factureexist === null)
						$facture = new FactureMail(new Facture());	
					else 
						$facture = new FactureMail($factureexist);
					if($nomfournisseur===null || $numerodocument===null || $date===null)
						throw new Exception("BAD FORMAT INVOICE");
						
					$fournisseur=$this->getFournisseur($nomfournisseur);
					if($fournisseur===null)
					//Problème Format facture ==> Nom fichier =>BADFOURNISSEUR
						$facture->setEtat("BAD FOURNISSEUR INVOICE");
					
					$dt=$this->toDate($date);
					//$this->logger->info($dt);
					if($dt===NULL)						
					{
						$dt=new \DateTime();
						$this->logger->info("BAD DATE FORMAT INVOICE");
						$facture->setEtat("BAD DATE FORMAT INVOICE");
					}
					$this->logger->info('N° Document: '.$numerodocument);
					$this->logger->info('Date Document: '.$date);
					  
					$facture->getfacture()->setName($numerodocument);
					$facture->getfacture()->setDateSaisie($dt);
					$facture->getfacture()->setCheckBl(true);
					if($fournisseur!=null)
						$facture->getfacture()->setFournisseur($fournisseur);
					return $facture;
					
			}
		}
	}
	
	private function toDate($stringdateEnt){
		
		$stringdate=str_replace(" ", "", $stringdateEnt);
		if (strlen($stringdate)!=8){
			$this->logger->error("String date ('".$stringdate."')<8 longueur : ".strlen($stringdate));
			return NULL;
		}
		$d=substr($stringdate,0,2);
		$m=substr($stringdate,2,2);
		$y=substr($stringdate,4,4);		
		try{
		$dt = new \DateTime($d."-".$m."-".$y);
		//$date = DateTime::createFromFormat('d/m/Y', $d."-".$m."-".$y);
                return $dt;//date->format('Y-m-d');
		//return null;
}catch(\Exception $e){return null;}
		return $dt;
	}
	
	private function getFournisseur($nomFournisseur){
		try{
			$this->logger->info('Fournisseur: '.$nomFournisseur.' existant?');
			$em=$this->doctrine->getManager();		
			$query=$em->createQuery("select a from AppBundle:Fournisseur a where replace(upper(a.name),' ','') = :id");
			$query->setParameter('id', strtoupper($nomFournisseur));
			$fournisseur=$query->getSingleResult();
			$this->logger->info('Fournisseur: '.$nomFournisseur.' trouvé');
			return $fournisseur;
		}catch (NoResultException $e){$this->logger->info('Fournisseur: '.$nomFournisseur.' inconnu');}
	}
	
	private function generateBL($filename,&$return){
	
		$array=explode("_",$filename);
		$nb=count($array);
		if($nb==4){
			$typedoc=strtoupper($array[0]);
			$nomfournisseur=$array[1];
			$numerodocument=$array[2];
			$date=explode(".",$array[3])[0];
				
			if(strpos($typedoc,"BONLIVRAISON") !==false){
				$this->logger->info('Bon de livraison n°: '.$numerodocument.' détectée');
				$BL = new \getMailFactBundle\GetMailFact\BonLivraisonMail(new Bon_livraison());				

				if($nomfournisseur===null || $numerodocument===null)
					throw new Exception("BAD FORMAT BL");
						
				$fournisseur=$this->getFournisseur($nomfournisseur);
				if($fournisseur===null)
					$BL->setEtat("BAD FOURNISSEUR BL");
							
				//$dt=$this->toDate($date);
				//if($dt===null)					
				//	$BL->setEtat("BAD DATE FORMAT BL");		

				$this->logger->info('N° Document: '.$numerodocument);
				$this->logger->info('Date Document: '.$date);
				$BL->getBonlivraison()->setName($numerodocument);
				
				return $BL;
			}
		}
	}
	
	
	private function generateFile($filename,\ezcMailPart $part){
		$fichier=new Fichier();
		$folder='';
		$pathname='';
		$this->generateFoldername($folder,$pathname);				
		$foldername=$pathname.basename( $part->contentDisposition->displayFileName );
		$this->logger->info('Enregistrement fichier: '.$foldername);
		rename( $part->fileName, $foldername);		
		$file=new \Symfony\Component\HttpFoundation\File\File($foldername) ;
		$fichier->setFile($file);
		$this->logger->info('Enregistrement nom fichier à ajouter dans base: '.$folder.'/'.basename( $part->contentDisposition->displayFileName ));
		$fichier->setName($folder.'/'.basename( $part->contentDisposition->displayFileName ));		
		return $fichier;
	}
}
