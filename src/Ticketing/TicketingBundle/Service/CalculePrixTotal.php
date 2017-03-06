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


    public function calculeTotalPrix($groupeVisiteur)
    {

        $totalPrix = 0;
        foreach ($groupeVisiteur as $visiteur) {
            $totalPrix = $totalPrix + $visiteur->getPrix();

        }


        return $totalPrix ;
    }

}