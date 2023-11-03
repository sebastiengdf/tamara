<?php

namespace getMailFactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use getMailFactBundle\GetMailFact\GetMailFact;
use Doctrine\Common\Persistence\ManagerRegistry;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	
      	$getMailFact=$this->container->get('get_mail_fact.getmailfact');    	
    	$getMailFact->integrateInvoice();
        return $this->render('getMailFactBundle:Default:index.html.twig');
    }
  
}
