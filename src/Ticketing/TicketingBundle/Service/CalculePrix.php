<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 23/02/2017
 * Time: 14:31
 */

namespace Ticketing\TicketingBundle\Service;


class CalculePrix
{
    public function prixTicket(\DateTime $dateDeNaissance, $reduction,$commande)
    {
          if (!$reduction) {

              $AujourdHui = new \DateTime();
        $age = $dateDeNaissance->diff($AujourdHui)->y;

        $prix = 16;

        if ($age < 4) {
            $prix = 0;
        } elseif ($age > 4 && $age < 12) {
            $prix = 8;
        } elseif ($age > 60) {
            $prix = 12;
        }
          }
          else {
              $prix = 10;
          }
        if ($commande === true) {
            $prix = $prix / 2;
        }
        return $prix;
    }
}