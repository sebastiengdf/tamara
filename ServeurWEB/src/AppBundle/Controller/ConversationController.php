<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conversation;
use AppBundle\Entity\HistoriqueNotification;
use AppBundle\Entity\Message;

use AppBundle\Entity\Notification;
use CoreBundle\Controller\AdminAjaxControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\UserBundle;
use FOS\UserBundle\Model\User;

class ConversationController extends Controller
{

    /**
     * @Route("/conversation/{id}", name="conversation")
     */
    public function conversationAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $conversation = $em->getRepository('AppBundle:Conversation')->findBy(array('facture' => $request->get('id')));
        $message = $em->getRepository('AppBundle:Message')->findBy(array('conversation' => $conversation));

        $unique_objects = array();
        foreach ($message as $item) {

            if (in_array($this->getUser(), $item->getConversation()->getUser()->toArray())) {
                $unique_objects[$item->getConversation()->getId()]['conversation'] = $item;

            }

        }
        $notification = $em->getRepository('AppBundle:Notification')->findBy(array('user' => $this->getuser()));

        foreach ($notification as $item) {

            $idConversation = $item->getMessage()->getConversation()->getId();
            $unique_objects[$idConversation]['id'] = $idConversation;
            $nbMessage = $em->getRepository('AppBundle:Notification')->findBy(array('message' => $item->getMessage()->getId(), 'user' => $item->getUser()->getId()));
            $unique_objects[$idConversation]['nbmessage'] = count($nbMessage);

        }

        return $this->render('AppBundle:Conversation:conversation.html.twig', array(
            'reponse' => $unique_objects,
            'id' => $request->get('id')
        ));

    }

    /**
     * @Route("/conversation/delete/{id}", name="conversation_delete")
     */
    public function conversationDeleteAction(Request $request,$id)
    {
        //todo desactive la conversation pour l"user si demande de la fonctionalités
        $em = $this->getDoctrine()->getManager();

        $conversation = $this->getDoctrine()->getRepository(Conversation::class)->find($id);
        $message = $em->getRepository('AppBundle:Message')->findBy(array('conversation' => $conversation));
        return new Response("Conversation supprimé   !");

    }


    /**
     * @Route("/message/{id}", name="message")
     */
    public function messageAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $conversation = $em->getRepository('AppBundle:Conversation')->findBy(array('facture' => $request->get('id'), "id" => $request->get('lastid')));
        $message = $em->getRepository('AppBundle:Message')->findBy(array('conversation' => $conversation));

        $unique_objects = array();
        foreach ($message as $item) {


            if (in_array($this->getUser(), $item->getConversation()->getUser()->toArray())) {
                $unique_objects[] = $item;
                $notification = $this->getDoctrine()->getRepository(Notification::class)->findBy(array('message' => $item->getId(), 'user' => $this->getUser()));

                foreach ($notification as $itemNotif) {

                    $em = $this->getDoctrine()->getManager();
                    $em->remove($itemNotif);
                    $em->flush();

                }
            }
        }

        return $this->render('AppBundle:Conversation:message.html.twig', array(
            'message' => $unique_objects,
            'user_connected'=>$this->getUser(),

            'id' => $request->get('id')
        ));

    }


    /**
     * Creates a new post entity.
     *
     * @Route("/conversation/{id}/new", name="new_conversation")
     *
     */
    public function newAction(Request $request, $id)
    {

        $conversation = new Conversation();
        $message = new Message();

        $formconversation = $this->createForm('AppBundle\Form\ConversationType', $conversation);
        $formconversation->handleRequest($request);

        if ($formconversation->isSubmitted() && $formconversation->isValid()) {

            $em = $this->getDoctrine()->getManager();
            // add conversation
            $facture = $em->getRepository('AppBundle:Facture')->find($id);
            $conversation->setDateCreation(new \DateTime('NOW'));
            $conversation->setFacture($facture);

            $em->persist($conversation);
            $em->flush();
            // add message

            $message->setDateCreation(new \DateTime('NOW'));
            $message->setConversation($conversation);
            $message->setCreatedMessage($this->getUser());
            $message->setContent($conversation->getContent());

            $em->persist($message);
            $em->flush();
            // add notification pour all user
            $this->createNotif($conversation);

            $conversationall=$em->getRepository('AppBundle:Conversation')->findBy(array('facture' => $id));
            $message = $em->getRepository('AppBundle:Message')->findBy(array('conversation' => $conversationall));

            return $this->render('AppBundle:Conversation:message.html.twig', array(
                'message'=>$message,
                'user_connected' => $this->getUser(),

                'id' => $request->get('id')
            ));
        }

        return $this->render("AppBundle:Conversation:new.html.twig", array(
            'conversation' => $conversation,
            'formconversation' => $formconversation->createView(),
            'user_connected' => $this->getUser(),

            'id' => $id
        ));
    }


    /**
     * Send message
     *
     * @Route("/conversation/{id}/update", name="update_conversation")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $message = new Message();
        $conversation = $this->getDoctrine()->getRepository(Conversation::class)->find($request->get("conversation"));
        $message->setDateCreation(new \DateTime('NOW'));

        $message->setConversation($conversation);
        $message->setContent($request->get("msg"));
        $message->setCreatedMessage($this->getUser());

        $em->persist($message);
        $em->flush();
        $this->createNotif($conversation);
        $message = $em->getRepository('AppBundle:Message')->findBy(array('conversation' => $conversation));

        return $this->render('AppBundle:Conversation:message.html.twig', array(
            'reponse' => $conversation,
            'message' => $message,
            'user_connected' => $this->getUser(),
            'id' => $request->get('id')
        ));

    }


    /**
     * @Route("/notification", name="notification")
     */
    public function notificationAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository('AppBundle:Notification')->findBy(array('user' => $this->getuser()));

        $unique_objects = array();
        foreach ($notification as $item) {

            $idConversation=$item->getMessage()->getConversation()->getId();
            $unique_objects[$idConversation]['id'] = $idConversation;
            $nbMessage = $em->getRepository('AppBundle:Notification')->findBy(array('message' =>$item->getMessage()->getId(),'user'=>$item->getUser()->getId()) );

            $unique_objects[$idConversation]['message']= $item->getMessage()->getId();
            $unique_objects[$idConversation]['user']= $item->getUser();
            $unique_objects[$idConversation]['dateCreation'] = $item->getDateCreation();
            $unique_objects[$idConversation]['nbmessage']=count($nbMessage);
            $unique_objects[$idConversation]['content']=$item->getMessage()->getConversation()->getTitle();


        }

        $historique= $em->getRepository('AppBundle:HistoriqueNotification')->findBy(array('user' => $this->getuser()));

        return $this->render('AppBundle:Conversation:notification.html.twig', array(
            'historique'=>$historique,

            'notification'=>$unique_objects,
            'nbnotif'=>count($unique_objects),
            'id' => $request->get('id')
        ));

    }

    /** redirection quand clique sur lien historique
     * @Route("/notification/historique/{conversation_id}", name="notification_historique")
     */
    public function notificationHistoriqueAction(Request $request,$conversation_id)
    {
        return $this->redirectToRoute('admin_app_factureall_show', array('id' =>$request->get('facture_id'),'idConversation' =>$conversation_id, 'modal'=>true));
    }

    /**
     * @Route("/notification/delete/{message_id}", name="notification_delete")
     */
    public function notificationDeleteAction(Request $request,$message_id)
    {

        $notification = $this->getDoctrine()->getRepository(Notification::class)->findBy(array('message' =>$message_id,'user'=>$request->get('user_id')));
        $dateNow = new \DateTime('NOW');
        foreach ($notification as $itemNotif) {
            $idFacture=$itemNotif->getMessage()->getConversation()->getFacture()->getId();
            $idConversation=$itemNotif->getMessage()->getConversation()->getId();

            $em = $this->getDoctrine()->getManager();
            $em->remove($itemNotif);
            $em->flush();
        }

        $histo = new HistoriqueNotification();
        $histo->setDateCreation($dateNow);// date creation histo
        $histo->setUser($this->getUser());

        $conversation = $this->getDoctrine()->getRepository(Conversation::class)->find($idConversation);
        $histo->setTitle($conversation->getTitle());
        $histo->setConversation($idConversation);
        $histo->setFacture($idFacture);
        $histo->setNbMessage(count($notification));
        $em->persist($histo);
        $em->flush();


        return $this->redirectToRoute('admin_app_factureall_show', array('id' =>$idFacture,'idConversation' =>$idConversation, 'modal'=>true));

    }

    /**
     * Mets à jour les notifs si date expiré de 3 jours depuis la creation
     *
     * @Route("
     * ", name="notification_maj")
     */
    public function notificationMajDeleteAction(Request $request)
    {
        $notification = $this->getDoctrine()->getRepository(Notification::class)->findAll();
        $dateNow = new \DateTime('NOW');

        foreach ($notification as $itemNotif) {

            if ($dateNow > $itemNotif->getDateCreation()->add(new \DateInterval('P3D'))) {
                $em = $this->getDoctrine()->getManager();

                $em->remove($itemNotif);
                $em->flush();
            }

        }
        return new Response("Mise a jour notification effectué    !");

    }

    private function createNotif(Conversation $conversation)
    {

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('AppBundle:Message')->findBy(array('conversation' => $conversation));

        foreach ($conversation->getUser() as $item) {

            // Ne pas envoyer de notif a soi méme
            if($item!=$this->getUser()){
                $notification = new Notification();
                $notification->setDateCreation(new \DateTime('NOW'));
                $notification->setUser($item);
                $notification->setMessage($message[0]);
                $notification->setStatutMail(0);

                $em->persist($notification);
                $em->flush();
            }

        }

    }

    /**
     * @Route("/sendmailnotification/{minutes}", name="sendmailnotification")
     */
    public function sendMailNotificationAction(Request $request,$minutes)
    {
        $em = $this->getDoctrine()->getManager();
        $user= $em->getRepository('UserBundle:User')->findAll();
        $today= new \DateTime('NOW');
        $today->modify("-{$minutes} minutes");

        $no_email = array();
        // recupére les user qui ne recevront pas de mail de notif
        foreach ($user as $item) {
            if($item->getLastLogin()>$today){
                $no_email[]=$item;
            }
        }

        $notification = $em->getRepository('AppBundle:Notification')->findAll();
        //dump($notification);
        //dump($no_email);
        //die;
        $send_email = array();
        // construction du tableau des notifications a envoyé
        foreach ($notification as $item) {

            if( !in_array( $item->getUser(),$no_email) && $item->getStatutMail()==0){
                // todo factoriser dans une fonctio

                $notification = $em->getRepository('AppBundle:Notification')->findBy(array('user' => $item->getUser()));

                foreach ($notification as $item2) {
                    //dump($notification);
                    //dump($no_email);
                    //die;
                    $iduser=$item2->getUser()->getId();
                    $idConversation=$item2->getMessage()->getConversation()->getId();
                    $send_email[$iduser][$idConversation]['id'] = $idConversation;
                    $nbMessage = $em->getRepository('AppBundle:Notification')->findBy(array('message' =>$item2->getMessage()->getId(),'user'=>$item2->getUser()->getId()) );

                    $send_email[$iduser][$idConversation]['message']= $item2->getMessage()->getId();
                    $send_email[$iduser][$idConversation]['user']= $item2->getUser();
                    $send_email[$iduser][$idConversation]['dateCreation'] = $item2->getDateCreation();
                    $send_email[$iduser][$idConversation]['nbmessage']=count($nbMessage);
                    $send_email[$iduser][$idConversation]['content']=$item2->getMessage()->getConversation()->getTitle();
                    //dump($send_email);
                    //dump($no_email);
                    //die;

                }
                // mets a jour le statut du mail envoyé soi a 1
                $item->setStatutMail(1);
                $em->persist($item);
                $em->flush();
            }

        }

        // envoie email a tous les destinataires
        foreach ($send_email as $item_mail) {
            $this->sendMailNotification($item_mail,"Vous avez reçu un nouveau message. sur Tamara.");
        }
        return new Response("Email envoyé a !".json_encode($send_email));

    }

    /** Envoie mail des notification recu
     *
     */
    private function sendMailNotification($message,$object){
        $mailer_user=$this->container->getParameter('mailer_user');
        $user=current($message)['user'];

        $dest=$user->getEmail();
        $message= $this->renderView(
            '@App/Conversation/Notification_mail.html.twig',
            ['notification' => $message , 'user'=>$user ]

        );

        $mime_message = (new \Swift_Message($object))->setFrom($mailer_user)->setTo($dest)->setBody($message,"text/html");
        $this->get('mailer')->send($mime_message);
    }

    /** Met a jpur lastlogin si utilisateur connecter
     * @Route("/updatelastlogin", name="updatelastlogin")
     */
    public function updateLastLoginAction()
    {
        /*$userManager = $this->get('fos_user.user_manager');
        $user = $this->getUser()->setLastLogin(new \DateTime('NOW'));
        $userManager->updateUser($user, true);*********
*/
        return new Response("Mise a jour last login user effectué    !");

    }


}
