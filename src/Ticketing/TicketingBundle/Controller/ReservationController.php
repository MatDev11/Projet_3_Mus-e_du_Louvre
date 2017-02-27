<?php

namespace Ticketing\TicketingBundle\Controller;

use Ticketing\TicketingBundle\Entity\Commande;
use Ticketing\TicketingBundle\Entity\Visiteur;

use Ticketing\TicketingBundle\Entity\Client;
use Ticketing\TicketingBundle\Form\CommandeType;
use Ticketing\TicketingBundle\Form\ClientType;
use Ticketing\TicketingBundle\Form\VisiteurType;
use Ticketing\TicketingBundle\Form\GroupeVisiteurType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;


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
        $form = $this->createForm(CommandeType::class, $commande);

        // Si la requête est en POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $session = $request->getSession();

            $session->set('commande', $commande);

            return $this->redirectToRoute('ticketing_reservation_ticket');

        }

        return $this->render('TicketingBundle:Reservation:Commande.html.twig', array('message' => $message,
            'form' => $form->createView()));
    }

    public function TicketAction(Request $request)//, Commande $commande)
    {
        $visiteur = new Visiteur();
        $session = $request->getSession();
        $commande = $request->getSession()->get('commande');


        $nbBillet = $commande->getQtePlace();// $session->getQtePlace();

        $form = $this->createForm(GroupeVisiteurType::class, null, ['nbBillet' => $nbBillet]);
        // $form   = $this->get('form.factory')->create(VisiteurType::class,$visiteur1);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $groupeVisiteur = $form->getData();
            $totalPrix1= 0;

            $em = $this->getDoctrine()->getManager();

            foreach ($groupeVisiteur as $visiteur) {
                $price = $this->get('ticketing.CalculePrix')->prixTicket($visiteur->getDateDeNaissance(),$visiteur->getReduction());//, $ticket->getDiscount());

                $visiteur->setCommande($commande);

                $visiteur->setPrix($price);
                $session->set('visiteurs', $groupeVisiteur);
               // $em->persist($visiteur);
               // $totalPrix = $this->get('ticketing.CalculePrix')->calculeTotalPrix($visiteur->getPrix(),$totalPrix1);
            }

            $totalPrix = $this->get('ticketing.CalculePrixTotal')->calculeTotalPrix($groupeVisiteur,$commande);

            //$session->set('totalPrix', $totalPrix);


            $commande->setPrixTotal($totalPrix);
          //  $em->persist($commande);
           // $em->persist($commande->getVisiteurs() );
          // $em->flush();

            return $this->redirectToRoute('ticketing_reservation_paiement');

        }


        return $this->render('TicketingBundle:Reservation:Ticket.html.twig', array('form' => $form->createView(),'visiteur' => $visiteur));


    }

    public function PaiementAction( Request $request)
    {
        $commande = $request->getSession()->get('commande');
        $totalPrix = $commande->getPrixTotal();
        $visiteurs = $request->getSession()->get('visiteurs');

        $client = new Client();



        // On crée le FormBuilder grâce au service form factory
        $form = $this->get('form.factory')->create(ClientType::class, $client)

                        ->add('submit',SubmitType::class)
        ;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();
            foreach ($visiteurs as $visiteur) {

                $em->persist($visiteur);
            }

            $em->persist($commande);
            $em->persist($client);


            $em->flush();


        }


        return $this->render('TicketingBundle:Reservation:Paiement.html.twig', array('form' => $form->createView(),'prix'=>$totalPrix));

    }
}
