<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 23/02/2017
 * Time: 14:31
 */

namespace Ticketing\TicketingBundle\Service;


class ControleSession
{
    public function sessionTicket($request)
    {
        $session = $request->getSession();
        if ($session->has('commande') !== true ) {

            return true;

        }

    }

    public function sessionPaiement($request)
    {
        $session = $request->getSession();
        if ($session->has('commande') !== true || $session->has('visiteurs') !== true ) {

            return true;

        }

    }

    public function sessionRecapPaiement($request)
    {
        $session = $request->getSession();
        if ($session->has('commande') !== true || $session->has('client') !== true || $session->has('visiteurs')!= true) {

            return true;

        }

    }

}