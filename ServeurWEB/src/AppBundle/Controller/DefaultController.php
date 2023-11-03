<?php

namespace AppBundle\Controller;

use CoreBundle\Controller\AdminAjaxControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //$path = $this->get("cms.template.hierarchy")->getBasePathShorcut();
        //return $this->render("$path/layout:layout_no_header_footer.html.twig");
        return $this->redirectToRoute('sonata_admin_dashboard');
    }
    
    
    private function sendMail($from,$dest,$message,$object,$facture){
        $base=$this->container->getParameter('upload_destination');
        $name=$facture->getFichier()->getName();
        $pdf= $base.'/'.$name;
        
        $this->get('logger')->info("Envoie mail à : ".$dest." - contenu: ".$message. " - attachement: ".$pdf. "- id_facture :".$facture->getId());
        $mime_message = (new \Swift_Message($object))->setFrom($from)->setTo($dest)->setBody($message,"text/html")
        ->attach(\Swift_Attachment::fromPath($pdf)->setFilename($name.'.pdf'));
        
        $this->get('mailer')->send($mime_message);
    }
    
    
    private function sendRedictedmail($message,$object,$facture){
        $from=$this->container->getParameter('mailer_user');
        $dest=$this->container->getParameter('dest_snow');
        $this->sendMail($from,$dest,$message,$object,$facture);
    }

    
    public function sendtosnow($facture,$bonsdecommande)
    {
        /*
         * Désactivation de l'envoi vers SNOW
         *
         * */
        
        $message=$this->renderView('getMailFact/send_notification_to_snow.html.twig', array(
            'facture' => $facture,
            'bonsdecommandes' =>$bonsdecommande
        ));
        
        $affectation=$facture->getAffectation();
        if($affectation!=null)
            $igg=$affectation->getUsername();
            else
            $igg=$this->container->getParameter('igg');
         $name=$facture->getFichier()->getName();
         $nom_societe=$this->container->getParameter('nom_societe');
         $macro_processus=$this->container->getParameter('macro_processus');
         $processus=$this->container->getParameter('processus');
         $sous_processus=$this->container->getParameter('sous_processus');
         $sous_sous_processus=$this->container->getParameter('sous_sous_processus');
         $object='e:\\\\'.$igg.'\\\\La Reunion\\\\'.$nom_societe.'\\\\'.$macro_processus.'\\\\'.$processus.'\\\\'.$sous_processus.'\\\\'.$sous_sous_processus.'\\\\'.$name.'.pdf';
                
         $this->sendRedictedmail($message,$object,$facture);
                
                
    }
    
    /**
     * @Route("/testsnow", name="testsnow")
     */
    public function testsnowAction(Request $request)
    {
        //$path = $this->get("cms.template.hierarchy")->getBasePathShorcut();
        //return $this->render("$path/layout:layout_no_header_footer.html.twig");
        $em=$this->getDoctrine()->getManager();
        
        
        
        $notifs=$em->getRepository('AppBundle\Entity\SnowQueuNotification')
        ->findBy(array('issended' => false));
        
        foreach ( $notifs as $notif ) {
            
            //obtention des bons decommande
            $bonsdecommande=$em->getRepository('AppBundle\Entity\Bon_commande')
            ->findBy(array('facture' => $notif->getFacture()));
           
            $this->sendtosnow($notif->getFacture(),$bonsdecommande);
            $notif->setIssended(true);
            $em->persist($notif);
        }
        $em->flush();
        $response = new Response();
        $response->setContent(json_encode([
            'sendmail' => 'ok'
        ]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    

}
