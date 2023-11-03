<?php

namespace WorkflowBundle\Workflow;

use Monolog\Logger;
use WorkflowBundle\Entity\Document;
use WorkflowBundle\Entity\WorkflowStep;
use WorkflowBundle\Entity\WorkflowTransition;
use WorkflowBundle\Entity\WorkflowCondition;
use WorkflowBundle\Exception\BadStepException;
use Doctrine\Common\Persistence\ManagerRegistry;

class Workflow
{
    private $document;

	private $logger;

	function __construct($logger, ManagerRegistry $doctrine){
        $this->logger=$logger;
        $this->doctrine=$doctrine;

        $this->logger->info("Mise en place du contenu du Workflow.");

        // On déclare nos arrays pour chaque type de donnée
        $workflowStepContent = array();
        $workflowTransitionContent = array();

        /*

        // Ajout de nos données en base
        $manager=$this->doctrine->getManager();
            
        $allWorkflowSteps = [];
        foreach ($workflowStepContent as $id=>$stepContent){
            $workflowStep = new WorkflowStep();
            $workflowStep->setLibelle($stepContent[0]);
            $workflowStep->setCode($stepContent[1]);
            $allWorkflowSteps[$id] = $workflowStep;
            $manager->persist($workflowStep);
        }
        $manager->flush();

        $allWorkflowTransitions = [];
        foreach ($workflowTransitionContent as $transitionContent){
            $workflowTransition = new WorkflowTransition();
            $workflowTransition->setSourceStep($allWorkflowSteps[$transitionContent[0]]);
            $workflowTransition->setTargetStep($allWorkflowSteps[$transitionContent[1]]);
            $workflowTransition->setLibelle($transitionContent[2]);
            $allWorkflowTransitions[] = $workflowTransition;
            $manager->persist($workflowTransition);
        }
        $manager->flush();

        */
	}

    /**
     * Enregistre le document à gérer
     *
     * @param \WorkflowBundle\Entity\Document $document
     *
     * @return Workflow
     */
    public function setDocument(\WorkflowBundle\Entity\Document $document){
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \WorkflowBundle\Entity\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    // Retourne un tableau contenant les steps où peut aller le document gérer
    public function getNextStep()
    {
        $allTransitions = $this->getDocument()->getStep()->getWorkflowTransitions();
        $nextSteps = [];
        foreach ($allTransitions as $transition){
            $nextSteps[] = $transition->getTargetStep();
            $this->logger->info('Pour le document actuel, un des steps suivants est : '.$transition->getTargetStep()->getLibelle());
        }
        return $nextSteps;
    }
    
 	
    
    public function getBaseRouteName($code){
    	$em=$this->doctrine->getManager();
    	$query=$em->createQuery("select a from WorkflowBundle:WorkflowStep a where replace(upper(a.code),' ','') = :code");
    	$query->setParameter('code', strtoupper($code));
    	$step=$query->getSingleResult();
    	if($step->getBaseRouteName()===null){
    		$query=$em->createQuery("select a from WorkflowBundle:WorkflowStep a where replace(upper(a.code),' ','') = :code");
    		$query->setParameter('code', strtoupper('INIT'));
    		$step=$query->getSingleResult();
    	}
    	return $step->getBaseRouteName();
    }
    
    public function getBaseRoutePattern($code){
    	$em=$this->doctrine->getManager();
    	$query=$em->createQuery("select a from WorkflowBundle:WorkflowStep a where replace(upper(a.code),' ','') = :code");
    	$query->setParameter('code', strtoupper($code));
    	$step=$query->getSingleResult();
    	if($step->getBaseRoutePattern()===null){
    		$query=$em->createQuery("select a from WorkflowBundle:WorkflowStep a where replace(upper(a.code),' ','') = :code");
    		$query->setParameter('code', strtoupper('INIT'));
    		$step=$query->getSingleResult();
    	}
    	return $step->getBaseRoutePattern();
    }
    
    

    private function getStatusByCode($code){
    	try{
    		$em = $this->modelManager->getEntityManager('getMailFactBundle\Entity\Status');
    		$query=$em->createQuery("select a from getMailFactBundle:status a where replace(upper(a.code),' ','') = :code");
    		$query->setParameter('code', strtoupper($code));
    		$status=$query->getSingleResult();
    		return $status;
    	}catch (\Doctrine\ORM\NoResultException $e){
    		return null;}
    }
    
    private function getStepByCode($code){
    	try{
    		$em = $this->doctrine->getEntityManager();    		
    		
    		//('WorkflowBundle\Entity\WorkflowStep');
    		$query=$em->createQuery("select a from WorkflowBundle:WorkflowStep a where replace(upper(a.code),' ','') = :code");
    		$query->setParameter('code', strtoupper($code));
    		$step=$query->getSingleResult();
    		return $step;
    	}
    	catch (\Doctrine\ORM\NoResultException $e)
    	{
    		return null;
    	}
    }
    
    public function manageStatus($status, Document $document){


    		//$step=$this->getStepByCode('FACTOAFF');
    		
    		if($status==='INIT'){
    			$nextstep=$this->getStepByCode($status);
    			$document->setStep($nextstep);
    			 
    		}
    		$this->setDocument($document);
    		$steps=$this-> getNextStep();
    	
    		if($steps !== null)
    		{
    				foreach ($steps as $nextstep){
						try{
    						$this->toStep($nextstep);
							return $nextstep;
						}catch(BadStepException $ex){}
    					
    				}
    		} 			
    		//return $step;
  
    	return null;
    }

    // Vérifie, et passe, si il est possible du step actuel vers le step en paramètre
    public function toStep(\WorkflowBundle\Entity\WorkflowStep $step)
    {
        $allTransitions = $this->getDocument()->getStep()->getWorkflowTransitions();
        // Vérification des conditions de la transition
        
        foreach($allTransitions as $transition){
        	$transition_agreement = true;
            // Vérification si le step de fin est celui en paramètre
            if($transition->getTargetStep() === $step){
            	$transition_agreement_tmp=true;
                $conditions = $transition->getWorkflowConditions();
                foreach($conditions as $condition){
                    $type = $condition->getConditionType();
                    // Conversion de la variable en son getter
                    $variable = $condition->getVariableName();
                    $variable = ucfirst($variable);
                    $variable = 'get'.$variable;
                    if(strcmp($type, 'notnull')== 0){
                        if($this->getDocument()->$variable() === null)
                        	$transition_agreement_tmp = false;
                    }
                    if(strcmp($type, 'isnull')== 0){
                    	if($this->getDocument()->$variable() !== null)
                    		$transition_agreement_tmp = false;
                    }
                    elseif(strcmp($type, 'istrue')== 0){
                        if($this->getDocument()->$variable() !== true && $this->getDocument()->$variable() !=="1")
                        	$transition_agreement_tmp = false;
                    }
                    elseif(strcmp($type, 'size>0')== 0){
                    	if(count($this->getDocument()->$variable())<=0)
                    		$transition_agreement_tmp = false;
                    } 
                    elseif(strcmp($type, 'size=0')== 0){
                    	if(count($this->getDocument()->$variable())>0)
                    		$transition_agreement_tmp = false;
                    }
                    
                    elseif(strcmp($type, '!istrue')== 0){
                    	if($this->getDocument()->$variable() === true)
                    		$transition_agreement_tmp = false;
                    }
                    $transition_agreement=$transition_agreement && $transition_agreement_tmp;
                }
                if ($transition_agreement){
                	$this->logger->info('Changement de step de '.$this->getDocument()->getStep()->getLibelle().' vers '.$step->getLibelle());
                	$this->getDocument()->setStep($step);
                	return $this;
                }
            }
        }
        
        if ($this->getDocument()->getStep() !== $step){
            $this->logger->info('Impossibilité de passer du step \''.$this->getDocument()->getStep()->getLibelle().'\' vers \''.$step->getLibelle().'\'');
            throw new BadStepException('Impossibilité de passer du step \''.$this->getDocument()->getStep()->getLibelle().'\' vers \''.$step->getLibelle().'\'');
        }
        return $this;
    }

    // Vérifie si le step actuel peut évoluer vers un autre step sans appel de toStep()
    public function updateStep()
    {
        $allTransitions = $this->getDocument()->getStep()->getWorkflowTransitions();
        foreach($allTransitions as $transition){
            // Vérification des conditions de la transition
            $newStep = null;
            $transition_agreement = true;
            $conditions = $transition->getWorkflowConditions();
            foreach($conditions as $condition){
                $type = $condition->getConditionType();
                // Conversion de la variable en son getter
                $variable = $condition->getVariableName();
                $variable = ucfirst($variable);
                $variable = 'get'.$variable;

                if(strcmp($type, 'manual') == 0){
                    $transition_agreement = false;
                    break;
                }
                elseif(strcmp($type, 'notnull')== 0){
                    if($this->getDocument()->$variable() === null)
                        $transition_agreement = false;
                }
                elseif(strcmp($type, 'istrue')== 0){
                    if($this->getDocument()->$variable() !== true)
                        $transition_agreement = false;
                }
            }
            if($transition_agreement){
                $newStep = $transition->getTargetStep();
                $this->logger->info('Changement de step de '.$this->getDocument()->getStep()->getLibelle().' vers '.$newStep->getLibelle());
                $this->getDocument()->setStep($transition->getTargetStep());
                break;
            }
        }
        return $this;
    }
}
