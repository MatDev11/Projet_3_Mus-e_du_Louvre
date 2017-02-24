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

    /**
     * @param $birthdate
     * @return mixed
     */
    public function pricing(\DateTime $birthdate)//, $discount)
    {


        //  if (!$discount) {

        $to = new \DateTime('today');
        $age = $birthdate->diff($to)->y;

        $price = 16;

        if ($age < 4) {
            $price = 0;
        } elseif ($age > 4 && $age < 12) {
            $price = 8;
        } elseif ($age > 60) {
            $price = 12;
        }


        //  }
        //  else {
        //     $price = $repository->findOneByName("reduit");
        //  }
        return $price;
    }


    /*  // Calcul de l'age
      public function calculAge($birthDate)
      {
          // Découpage date de naissance
          $year =  intval(date('Y', $birthDate->getTimestamp()));
          $month = intval(date('m', $birthDate->getTimestamp()));
          $day = intval(date('d', $birthDate->getTimestamp()));

          // Découpage date actuelle
          $y = intval(date('Y'));
          $m = intval(date('m'));
          $d = intval(date('d'));

          if (($month < $m) || (($month == $m) && ($day <= $d))) {
              $age = $y - $year;
              return $age;
          } else {
              $age = ($y - $year) - 1;
              return $age;
          }

      }
      // Calcul du tarif
      public function calculPrice($age, $reducedPrice, $halfDay) {
          $price = 16;

          if ($age < 4) {
              $price = 0;
          } elseif ($age > 4 && $age < 12) {
              $price = 8;
          } elseif ($age > 60) {
              $price = 12;
          }

          if ($halfDay == true) {
              $price = $price / 2;
          }

          if ($reducedPrice == true) {
              $price = $price - 10;
          }

          return $price;
      }*/

}