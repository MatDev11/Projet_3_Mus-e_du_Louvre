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
    private $envoieMail;
    private $persistEntity;
    private $stripekey;
    private $publicStripkey;

    public function __construct($stripekey, $publicStripkey, $envoieMail, $persistEntity)
    {
        $this->stripekey = $stripekey;
        $this->publicStripkey = $publicStripkey;
        $this->envoieMail = $envoieMail;
        $this->persistEntity = $persistEntity;
    }

    public function publicStripkey()
    {
        return $this->publicStripkey;
    }

    public function paiementStripe($commande, $token, $client)
    {

        \Stripe\Stripe::setApiKey($this->stripekey);

        \Stripe\Charge::create(array(
            "amount" => $commande->getPrixTotal() * 100,
            "currency" => "eur",
            "source" => $token,
            "description" => 'paiement louvre',
        ));
        $this->persistEntity->persistEntity($commande->getVisiteurs(), $commande, $client);
        $this->envoieMail->sendMail($commande, $client, $commande->getVisiteurs());


    }

}