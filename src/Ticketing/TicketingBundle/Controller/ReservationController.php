<?php

namespace Ticketing\TicketingBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
    public function CommandeAction(Request $request)
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande)
            ->add('reserver', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
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
        $nbBillet = $commande->getQtePlace();

        if($session->has('commande') != true){

            return $this->redirectToRoute('ticketing_reservation_home');

        }

        $form = $this->createForm(GroupeVisiteurType::class, null, ['nbBillet' => $nbBillet])
            ->add('Suivant', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $groupeVisiteur = $form->getData();

            foreach ($groupeVisiteur as $visiteur)
            {
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
        $commande = $request->getSession()->get('commande');
        $totalPrix = $commande->getPrixTotal();
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client)//;
        ->add('Suivant', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $session->set('client', $client);

            return $this->redirectToRoute('ticketing_reservation_recapPaiement');

        }
        return $this->render('TicketingBundle:Reservation:Paiement.html.twig', array('form' => $form->createView(), 'prix' => $totalPrix * 100));
    }

    public function RecapPaiementAction(Request $request)
    {
        $commande = $request->getSession()->get('commande');
        $totalPrix = $commande->getPrixTotal();
        $visiteurs = $request->getSession()->get('visiteurs');
        $client = $request->getSession()->get('client');

        $form = $this->createFormBuilder()
            ->add('cvg', CheckboxType::class, array(
                'label' => 'En cochant vous acceptez les conditions générales de vente :',
                'required' => false,))
             ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $token = $request->get('stripeToken');
            try {
                $this->get('ticketing.PaiementStripe')->paiementStripe($commande, $token);
                $commande->setStatut("Payée");
                $em = $this->getDoctrine()->getManager();

                foreach ($visiteurs as $visiteur)
                {
                    $em->persist($visiteur);
                }
                $em->persist($commande);
                $em->persist($client);
                $em->flush();
                $this->get('ticketing.EnvoieEmail')->sendMail($commande, $client, $visiteurs);
                $this->addFlash('success', 'Paiement ok');
                return $this->redirectToRoute('ticketing_reservation_home');

            } catch (\Stripe\Error\Card $e)
            {
                $this->addFlash('danger', 'Paiement ko');
                return $this->redirect($request->getUri());
            }
        }

        return $this->render('TicketingBundle:Reservation:RecapPaiement.html.twig', array('form' => $form->createView(), 'commande' => $commande, 'client' => $client, 'visiteurs' => $visiteurs, 'prix' => $totalPrix * 100));

    }
}
