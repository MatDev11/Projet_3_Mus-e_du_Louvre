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
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande)
                     ->add('Suivant', SubmitType::class );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $session = $request->getSession();

            $session->set('commande', $commande);

            return $this->redirectToRoute('ticketing_reservation_ticket');

        }

        return $this->render('TicketingBundle:Reservation:Commande.html.twig', array('form' => $form->createView()));
    }

    public function TicketAction(Request $request)
    {
        $visiteur = new Visiteur();
        $session = $request->getSession();
        $commande = $request->getSession()->get('commande');


        $nbBillet = $commande->getQtePlace();// $session->getQtePlace();

        $form = $this->createForm(GroupeVisiteurType::class, null, ['nbBillet' => $nbBillet])
                     ->add('Suivant', SubmitType::class );


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $groupeVisiteur = $form->getData();

            foreach ($groupeVisiteur as $visiteur) {
                $price = $this->get('ticketing.CalculePrix')->prixTicket($visiteur->getDateDeNaissance(), $visiteur->getReduction());

                $visiteur->setCommande($commande);

                $visiteur->setPrix($price);
                $session->set('visiteurs', $groupeVisiteur);
            }

            $totalPrix = $this->get('ticketing.CalculePrixTotal')->calculeTotalPrix($groupeVisiteur, $commande);

            $commande->setPrixTotal($totalPrix);
            $this->addFlash('success','Paiement ok');

            return $this->redirectToRoute('ticketing_reservation_paiement');

        }


        return $this->render('TicketingBundle:Reservation:Ticket.html.twig', array('form' => $form->createView(), 'visiteur' => $visiteur));


    }

    public function PaiementAction(Request $request)
    {
        $commande = $request->getSession()->get('commande');
        $totalPrix = $commande->getPrixTotal();
        $visiteurs = $request->getSession()->get('visiteurs');

        $client = new Client();


        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(ClientType::class, $client);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $token = $request->get('stripeToken');
            try {

                $paiementStripe = $this->get('ticketing.PaiementStripe')->paiementStripe($commande, $token);

                $commande->setStatut("Payée");

                $em = $this->getDoctrine()->getManager();

                foreach ($visiteurs as $visiteur) {
                    $em->persist($visiteur);
                }
                $em->persist($commande);
                $em->persist($client);
                $em->flush();
                $this->addFlash('success','Paiement ok');
                return $this->redirectToRoute('ticketing_reservation_home');

            } catch(\Stripe\Error\Card $e) {

                $this->addFlash('danger','Paiement ko');
                return $this->redirect($request->getUri());

            }

        }


        return $this->render('TicketingBundle:Reservation:Paiement.html.twig', array('form' => $form->createView(), 'prix' => $totalPrix));

    }
}
