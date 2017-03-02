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
    public function prixTicket(\DateTime $dateDeNaissance, $reduction)
    {
          if (!$reduction) {

        $today = new \DateTime('today');
        $age = $dateDeNaissance->diff($today)->y;

        $price = 16;

        if ($age < 4) {
            $price = 0;
        } elseif ($age > 4 && $age < 12) {
            $price = 8;
        } elseif ($age > 60) {
            $price = 12;
        }
          }
          else {
             $price = 10;
          }
        return $price;
    }

}