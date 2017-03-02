<?php

namespace Ticketing\TicketingBundle\Service;


use Symfony\Component\Templating\EngineInterface;

class EnvoieEmail
{
    private $mailer;
    private $templating;
    private $from = "t_mathieu9@hotmail.fr";
    private $reply = "t_mathieu9@hotmail.fr";
    private $name = " Musée du Louvre ";

    public function __construct($mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    protected function sendMessage($to, $subject, $body, $totalPrix)
    {
        $mail = \Swift_Message::newInstance();
        $cid = $mail->embed(\Swift_Image::fromPath('./img/logo_Louvre.png'));
        $mail
            ->setFrom($this->from,$this->name)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody( $this->templating->render('TicketingBundle:Reservation:Email.html.twig', array('commande' => $body, 'image' => $cid, 'orderAmount'=>$totalPrix)))
            ->setReplyTo($this->reply,$this->name)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }

    public function sendMail($commande,$client, $totalPrix){
        $subject = "Commande " . $commande->getNumCommande() . " confirmation";
        $to = $client->getEmail();
        $this->sendMessage($to, $subject, $commande, $totalPrix);
    }
}
