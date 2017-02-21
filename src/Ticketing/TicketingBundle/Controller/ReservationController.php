<?php

namespace Ticketing\TicketingBundle\Controller;

use Ticketing\TicketingBundle\Entity\Commande;
use Ticketing\TicketingBundle\Entity\Visiteur;

use Ticketing\TicketingBundle\Entity\Client;
use Ticketing\TicketingBundle\Form\CommandeType;
use Ticketing\TicketingBundle\Form\ClientType;
use Ticketing\TicketingBundle\Form\VisiteurType;
use Ticketing\TicketingBundle\Form\GroupeVisiteurType;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ReservationController extends Controller
{
    public function CommandeAction(Request $request)
    {
        $message = '';

        // On crée un objet commande
        $commande = new Commande();
        // On crée le FormBuilder grâce au service form factory
        $form = $this->get('form.factory')->create(CommandeType::class, $commande);

        // Si la requête est en POST
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $session = $request->getSession();

            $session->set('commande', $commande);

            return $this->redirectToRoute('ticketing_reservation_ticket');

        }

        return $this->render('TicketingBundle:Reservation:Commande.html.twig', array('message' => $message,
            'form' => $form->createView()));
    }

    public function TicketAction(Request $request)//, Commande $commande)
    {

        $commande = $request->getSession()->get('commande');


        $nbBillet = $commande->getQtePlace();// $session->getQtePlace();

        $form = $this->createForm(GroupeVisiteurType ::class, null, ['nbBillet' => $nbBillet]);
        // $form   = $this->get('form.factory')->create(VisiteurType::class,$visiteur1);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $groupeVisiteur = $form->getData();


            $em = $this->getDoctrine()->getManager();

            foreach ($groupeVisiteur as $visiteur) {
                $visiteur->setCommande($commande);
                $em->persist($visiteur);
            }

            $em->flush();

            return new Response($content);

        }


        return $this->render('TicketingBundle:Reservation:Ticket.html.twig', array('form' => $form->createView()));


    }

    public function PaiementAction($id, Request $request)
    {

        $client = new Client();

        $commande = $this->getDoctrine()
            ->getManager()
            ->getRepository('TicketingBundle:commande')
            ->find($id);

        // On crée le FormBuilder grâce au service form factory
        $form = $this->get('form.factory')->create(ClientType::class, $client);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $em->persist($client);


            $em->flush();


        }


        return $this->render('TicketingBundle:Reservation:Paiement.html.twig', array('form' => $form->createView(), 'prix' => $id));

    }
}
