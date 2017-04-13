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


    private $stripekey;
    private $publicStripkey;

    public function __construct($stripekey,$publicStripkey)
    {
        $this->stripekey = $stripekey;
        $this->publicStripkey = $publicStripkey;
    }
    public function publicStripkey()
    {
        return $this->publicStripkey;
    }

    public function paiementStripe($commande, $token)
    {
        \Stripe\Stripe::setApiKey($this->stripekey);

        \Stripe\Charge::create(array(
            "amount" => $commande->getPrixTotal() * 100,
            "currency" => "eur",
            "source" => $token,
            "description" => 'paiement louvre',
        ));
    }
}