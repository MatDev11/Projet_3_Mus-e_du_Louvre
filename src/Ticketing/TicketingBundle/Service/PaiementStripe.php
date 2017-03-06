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


    public function paiementStripe($commande,$token)
    {

        \Stripe\Stripe::setApiKey("sk_test_8SR7kvJBumqoTbohzb613P1f");

        \Stripe\Charge::create(array(
            "amount" => $commande->getPrixTotal()*100,
            "currency" => "eur",
            "source" => $token,
            "description" =>'paiement louvre',
        ));



    }

}