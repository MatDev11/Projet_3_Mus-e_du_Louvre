<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 23/02/2017
 * Time: 14:31
 */

namespace Ticketing\TicketingBundle\Service;


class SessionTicket
{


    public function sessionTicket($groupeVisiteur, $request, $commande)
    {
        $newVisiteur = true;
        if (count($commande->getVisiteurs()) != 0) {
            $newVisiteur = false;
        }

        foreach ($groupeVisiteur as $visiteur) {
            $prix = $this->prixTicket($visiteur->getDateDeNaissance(), $visiteur->getReduction(), $commande->getTypeTarif());
            $visiteur->setCommande($commande);
            $visiteur->setPrix($prix);
            if ($newVisiteur === true) {
                $commande->addVisiteur($visiteur);
            }
            else {

                $commande->removeVisiteur($visiteur);

            }
        }

        $totalPrix = $this->calculeTotalPrix($groupeVisiteur);
        $commande->setPrixTotal($totalPrix);
    }


    public function prixTicket(\DateTime $dateDeNaissance, $reduction, $commande)
    {
        if (!$reduction) {

            $AujourdHui = new \DateTime();
            $age = $dateDeNaissance->diff($AujourdHui)->y;

            $prix = 16;

            if ($age < 4) {
                $prix = 0;
            } elseif ($age >= 4 && $age <= 12) {
                $prix = 8;
            } elseif ($age > 60) {
                $prix = 12;
            }
        } else {
            $prix = 10;
        }
        if ($commande === true) {
            $prix = $prix / 2;
        }
        return $prix;
    }

    public function calculeTotalPrix($groupeVisiteur)
    {
        $totalPrix = 0;
        foreach ($groupeVisiteur as $visiteur) {
            $totalPrix = $totalPrix + $visiteur->getPrix();
        }
        return $totalPrix;
    }

}