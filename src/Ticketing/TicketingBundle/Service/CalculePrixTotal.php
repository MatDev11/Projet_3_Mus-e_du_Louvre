<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 23/02/2017
 * Time: 14:31
 */

namespace Ticketing\TicketingBundle\Service;


class CalculePrixTotal
{


    public function calculeTotalPrix($groupeVisiteur,$commande)
    {

        $totalPrix = 0;
        foreach ($groupeVisiteur as $visiteur) {
            $totalPrix = $totalPrix + $visiteur->getPrix();
        }
       if ($commande->getTypeTarif()=== true) {
           $totalPrix = $totalPrix / 2;
        }

        return $totalPrix * 100;
    }

}