<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 23/02/2017
 * Time: 14:31
 */

namespace Ticketing\TicketingBundle\Service;


class PaiementStripe
{


    public function paiementStipe($commande,$token)
    {

        \Stripe\Stripe::setApiKey("sk_test_8SR7kvJBumqoTbohzb613P1f");

        \Stripe\Charge::create(array(
            "amount" => $commande->getPrix(),
            "currency" => "eur",
            "source" => $token,
            "description" => $commande->getName(),
        ));



    }

}