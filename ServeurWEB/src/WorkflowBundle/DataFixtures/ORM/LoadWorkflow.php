<?php

namespace WorkflowBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use WorkflowBundle\Entity\WorkflowStep;
use WorkflowBundle\Entity\WorkflowTransition;
use WorkflowBundle\Entity\WorkflowCondition;
use Doctrine\Common\Persistence\ObjectManager;

class LoadWorkflow implements FixtureInterface{
	/**
	 * {@inheritDoc}
	 * @see \Doctrine\Common\DataFixtures\FixtureInterface::load()
	 */
	public function load(ObjectManager $manager) {
                // On ajoute le contenu de WorkflowStep
        	$workflowStepContent = array(
        				
                        "INIT" => array(                        		
	                        "code"=>"INIT",                        		
	                        "libelle"=>"Initialisation",
	                        "baseRouteName"=>"--",
	                        "baseRoutePattern"=>"--"
                        ),
                                			
                        //"FACERR" => "Facture en erreur",
	        			"FACERR" => array(
	        					"code"=>"FACERR",
	        					"libelle"=>"Facture en erreur",
	        					"baseRouteName"=>"admin_app_factureenerreur",
	        					"baseRoutePattern"=>"app/factureenerreur"
	        			),  
						//"FACTOAFF" => "Facture à affecter",
        				"FACTOAFF" => array(
        					"code"=>"FACTOAFF",
        					"libelle"=>"Facture à affecter",
        					"baseRouteName"=>"admin_app_factureaaffecter",
        					"baseRoutePattern"=>"app/factureaaffecter"
        				),
                        //"FACTOWRI" => "Facture à saisir",
        				"FACTOWRI" => array(
        					"code"=>"FACTOWRI",
        					"libelle"=>"Facture à saisir",
        					"baseRouteName"=>"admin_app_factureasaisir",
        					"baseRoutePattern"=>"app/factureasaisir"
        				),
        			
                        //"FACTOAPP" => "Facture à approuver",
        				"FACTOAPP" => array(
        					"code"=>"FACTOAPP",
        					"libelle"=>"Facture à approuver",
        					"baseRouteName"=>"admin_app_factureaapprouver",
        					"baseRoutePattern"=>"app/factureaapprouver"
        				),
						//"FACTOWAITBC" => "Facture en attente de BC",
        				"FACTOWAITBC" => array(
        					"code"=>"FACTOWAITBC",
        					"libelle"=>"Facture en attente de BC",
        					"baseRouteName"=>"admin_app_factureattentebc",
        					"baseRoutePattern"=>"app/factureattentebc"
        				),
						//"FACTOVAL" => "Facture à valider",
        				"FACTOVAL" => array(
        					"code"=>"FACTOVAL",
        					"libelle"=>"Facture à valider",
        					"baseRouteName"=>"admin_app_factureavalider",
        					"baseRoutePattern"=>"app/factureavalider"
        				),
						//"FACTOPAY" => "Facture à payer",
        				"FACTOPAY" => array(
        					"code"=>"FACTOPAY",
        					"libelle"=>"Facture à payer",
        					"baseRouteName"=>"admin_app_factureapayer",
        					"baseRoutePattern"=>"app/factureapayer"
        				),
        			
						//"FACISPAY" => "Facture payée"
        			"FACISPAY" => array(
        					"code"=>"FACISPAY",
        					"libelle"=>"Facture paye",
        					"baseRouteName"=>"admin_app_facturepaye",
        					"baseRoutePattern"=>"app/facturepaye"
        			),
        			"FACNOAPP" => array(
        					"code"=>"FACNOAPP",
        					"libelle"=>"Facture non appouvées",
        					"baseRouteName"=>"admin_app_facturenonapprouve",
        					"baseRoutePattern"=>"app/facturenonapprouvee"
        					//FACNOAPP ==> Facture non appouvées
        			),
                );

                $allWorkflowSteps = [];
                
                foreach ($workflowStepContent as $row){
                	$workflowStep= new WorkflowStep();
                	$workflowStep->setLibelle($row['libelle']);
                	$workflowStep->setCode($row['code']);
                	$workflowStep->setBaseRouteName($row['baseRouteName']);
                	$workflowStep->setBaseRoutePattern($row['baseRoutePattern']);
                	$allWorkflowSteps[] = $workflowStep;
                	$manager->persist($workflowStep);
                }
               
                $manager->flush();

                // On ajoute le contenu de WorkflowTransitions
                $workflowTransitionContent = array(
                        array(0, 1, "Récupération ratée"),
                        array(0, 2, "Récupération réussie"),
                        array(1, 2, "Correction"),
                        array(2, 3, "Affectation"),
                        array(3, 4, "En attente d'approbation"),
                        array(4, 3, "Approbation"),
                        array(3, 5, "En attente de bon de commande"),
                        array(5, 3, "Fin d'attente de bon de commande"),
                        array(3, 6, "Saisie"),
                        array(6, 7, "Validation"),
                        array(7, 8, "Paiement"),
                		array(4, 9, "Non approbation")
                );

                $allWorkflowTransitions = [];

                foreach ($workflowTransitionContent as $content){
                        $workflowTransition = new WorkflowTransition();
                        $workflowTransition->setSourceStep($allWorkflowSteps[$content[0]]);
                        $workflowTransition->setTargetStep($allWorkflowSteps[$content[1]]);
                        $workflowTransition->setLibelle($content[2]);
                        $allWorkflowTransitions[] = $workflowTransition;
                        $manager->persist($workflowTransition);
                }
                $manager->flush();

                // On ajoute le contenu de WorkflowConditions
                $workflowConditionContent = array(
                        array(2, "notnull", "fournisseur"),
                        array(3, "notnull", "affectation"),
                        array(4, "notnull", "approbateur"),
                        array(5, "manual", null),
                       // array(6, "istrue", "check_approuve"),
                		array(6, "notnull", "approbateur"),
                		array(11, "!istrue", 'check_approuve'),
                		//array(3, "ORistrue", 'check_approuve'),
                        array(7, "manual", null),
                        array(8, "manual", null),
                        array(9, "istrue", "check_valide"),
                        array(10, "istrue", "check_paye"),
                		array(11, "!istrue", "check_paye")
                );

                foreach($workflowConditionContent as $content){
                        $workflowCondition = new WorkflowCondition();
                        $workflowCondition->setWorkflowTransition($allWorkflowTransitions[$content[0]]);
                        $workflowCondition->setConditionType($content[1]);
                        $workflowCondition->setVariableName($content[2]);
                        $manager->persist($workflowCondition);
                }
                $manager->flush();
        }
}