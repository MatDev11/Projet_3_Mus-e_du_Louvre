<?php

namespace Ticketing\TicketingBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Ticketing\TicketingBundle\Entity\Commande;
use Ticketing\TicketingBundle\Entity\Visiteur;
use Ticketing\TicketingBundle\Entity\Client;
use Ticketing\TicketingBundle\Form\CommandeType;
use Ticketing\TicketingBundle\Form\ClientType;
use Ticketing\TicketingBundle\Form\GroupeVisiteurType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $session = $request->getSession();

        if ($session->has('commande') !== true) {

            return $this->redirectToRoute('ticketing_reservation_home');

        }

        $visiteur = new Visiteur();
        $commande = $request->getSession()->get('commande');
        $nbBillet = $commande->getQtePlace();


        $form = $this->createForm(GroupeVisiteurType::class, null, ['nbBillet' => $nbBillet])
            ->add('Retour', ButtonType::class, array('attr' => array('class' => 'btn btn-warning col-lg-4 col-sm-4  col-xs-12 bouton ',
                'onclick'=>'history.go(-1)')))
            ->add('Suivant', SubmitType::class, array('attr' => array('class' => 'btn btn-primary col-lg-4 col-sm-4 col-xs-12 bouton')));


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $groupeVisiteur = $form->getData();

            foreach ($groupeVisiteur as $visiteur) {
                $prix = $this->get('ticketing.CalculePrix')->prixTicket($visiteur->getDateDeNaissance(), $visiteur->getReduction(), $commande->getTypeTarif());
                $visiteur->setCommande($commande);
                $visiteur->setPrix($prix);
                $session->set('visiteurs', $groupeVisiteur);
            }

            $totalPrix = $this->get('ticketing.CalculePrixTotal')->calculeTotalPrix($groupeVisiteur);
            $commande->setPrixTotal($totalPrix);
            $this->addFlash('success', 'Paiement ok');

            return $this->redirectToRoute('ticketing_reservation_paiement');
        }

        return $this->render('TicketingBundle:Reservation:Ticket.html.twig', array('form' => $form->createView(), 'visiteur' => $visiteur));
    }

    public function PaiementAction(Request $request)
    {
        $session = $request->getSession();

        $client = new Client();

        $form = $this->createForm(ClientType::class, $client)
            ->add('Retour', ButtonType::class, array('attr' => array('class' => 'btn btn-warning col-lg-4 col-sm-4  col-xs-12 bouton ',
                'onclick'=>'history.go(-1)')))
            ->add('Suivant', SubmitType::class, array('attr' => array('class' => 'btn btn-primary col-lg-4 col-sm-4 col-xs-12 bouton')));


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $session->set('client', $client);

            return $this->redirectToRoute('ticketing_reservation_recapPaiement');

        }
        return $this->render('TicketingBundle:Reservation:Paiement.html.twig', array('form' => $form->createView()));
    }

    public function recapPaiementAction(Request $request)
    {
        $session = $request->getSession();
        if ($session->has('commande') !== true || $session->has('client') !== true || $session->has('visiteurs')!= true) {

            return $this->redirectToRoute('ticketing_reservation_home');

        }

        $commande = $request->getSession()->get('commande');
        $totalPrix = $commande->getPrixTotal();
        $visiteurs = $request->getSession()->get('visiteurs');
        $client = $request->getSession()->get('client');

        $form = $this->createFormBuilder()
            ->getForm();

        $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid() && !empty($_POST['cvgTest'])) {
            $token = $request->get('stripeToken');
            try {
                $this->get('ticketing.PaiementStripe')->paiementStripe($commande, $token);
                $commande->setStatut("Payée");
                $commande->setCvg(true);
                $em = $this->getDoctrine()->getManager();

                foreach ($visiteurs as $visiteur) {
                    $em->persist($visiteur);
                }
                $em->persist($commande);
                $em->persist($client);
                $em->flush();
                $this->get('ticketing.EnvoieEmail')->sendMail($commande, $client, $visiteurs);
                $this->get('session')->clear();
                $this->get('session')->getFlashBag()->clear();
                $this->addFlash('success', 'Paiement accepté. Le Musée du Louvre vous remercie de votre réservation et vous souhaite une agréable visite !');
                return $this->redirectToRoute('ticketing_reservation_home');

            } catch (\Stripe\Error\Card $e) {
                $this->addFlash('Err', 'Paiement refuser réessayer!');
                return $this->redirect($request->getUri());
            }
        }
        if ($form->isSubmitted()  && empty($_POST['cvgTest']))
        {
            $this->addFlash('Err', 'Vous devez accepter les conditions de la vente.!');
        }

        return $this->render('TicketingBundle:Reservation:RecapPaiement.html.twig', array('form' => $form->createView(), 'commande' => $commande, 'client' => $client, 'visiteurs' => $visiteurs, 'prix' => $totalPrix * 100));

    }
}
