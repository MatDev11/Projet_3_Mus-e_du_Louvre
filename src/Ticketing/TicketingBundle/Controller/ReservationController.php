<?php

namespace Ticketing\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Ticketing\TicketingBundle\Entity\Client;
use Ticketing\TicketingBundle\Entity\Commande;
use Ticketing\TicketingBundle\Entity\Visiteur;
use Ticketing\TicketingBundle\Form\ClientType;
use Ticketing\TicketingBundle\Form\CommandeType;
use Ticketing\TicketingBundle\Form\GroupeVisiteurType;


class ReservationController extends Controller
{


    public function commandeAction(Request $request)
    {
        $commande = new Commande();


        $form = $this->createForm(CommandeType::class, $commande)
            ->add('reserver', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $request->getSession();
            $session->set('commande', $commande);
            $this->get('session')->getFlashBag()->clear();
            return $this->redirectToRoute('ticketing_reservation_ticket');
        }
        return $this->render('TicketingBundle:Reservation:Commande.html.twig', array('form' => $form->createView()));
    }

    public function ticketAction(Request $request)
    {

        if ($this->get('ticketing.ControleSession')->controleSession1($request)) {

            return $this->redirectToRoute('ticketing_reservation_home');
        }

        $visiteur = new Visiteur();
        $commande = $request->getSession()->get('commande');
        $nbBillet = $commande->getQtePlace();


        $form = $this->createForm(GroupeVisiteurType::class, null, ['nbBillet' => $nbBillet])
            ->add('Suivant', SubmitType::class, array('attr' => array('class' => 'btn btn-primary col-lg-4 col-sm-4 col-xs-12 bouton')))
            ->add('Retour', ButtonType::class, array('attr' => array('class' => 'btn btn-warning col-lg-4 col-sm-4  col-xs-12 bouton ', 'onclick' => 'history.go(-1)')));


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $groupeVisiteur = $form->getData();

            $this->get('ticketing.SessionTicket')->sessionTicket($groupeVisiteur, $request, $commande);

            return $this->redirectToRoute('ticketing_reservation_paiement');
        }

        return $this->render('TicketingBundle:Reservation:Ticket.html.twig', array('form' => $form->createView(), 'visiteur' => $visiteur));
    }

    public function PaiementAction(Request $request)
    {

        if ($this->get('ticketing.ControleSession')->controleSession1($request)) {

            return $this->redirectToRoute('ticketing_reservation_home');
        }
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client)
            ->add('Suivant', SubmitType::class, array('attr' => array('class' => 'btn btn-primary col-lg-4 col-sm-4 col-xs-12 bouton')))
            ->add('Retour', ButtonType::class, array('attr' => array('class' => 'btn btn-warning col-lg-4 col-sm-4  col-xs-12 bouton ', 'onclick' => 'history.go(-1)')));


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $request->getSession()->set('client', $client);

            return $this->redirectToRoute('ticketing_reservation_recapPaiement');

        }
        return $this->render('TicketingBundle:Reservation:Paiement.html.twig', array('form' => $form->createView()));
    }

    public function recapPaiementAction(Request $request)
    {

        if ($this->get('ticketing.ControleSession')->controleSession2($request)) {

            return $this->redirectToRoute('ticketing_reservation_home');

        }
        $publicStripkey = $this->get('ticketing.PaiementStripe')->publicStripkey();
        $commande = $request->getSession()->get('commande');
        $client = $request->getSession()->get('client');

        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && !empty($_POST['cvgTest'])) {
            $token = $request->get('stripeToken');
            try {
                $this->get('ticketing.PaiementStripe')->paiementStripe($commande, $token, $client);
                $this->get('session')->clear();
                $this->addFlash('success', 'Paiement accepté. Le Musée du Louvre vous remercie de votre réservation et vous souhaite une agréable visite !');
                return $this->redirectToRoute('ticketing_reservation_home');

            } catch (\Stripe\Error\Card $e) {

                return $this->redirect($request->getUri());
            }
        }
        if ($form->isSubmitted() && empty($_POST['cvgTest'])) {
            $this->addFlash('Err', 'Vous devez accepter les conditions de la vente.!');
        }

        return $this->render('TicketingBundle:Reservation:RecapPaiement.html.twig', array('form' => $form->createView(), 'commande' => $commande, 'client' => $client, 'visiteurs' => $commande->getVisiteurs(), 'prix' => $commande->getPrixTotal() * 100, 'publicStripkey' => $publicStripkey));

    }
}
