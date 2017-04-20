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
    public function controleSession1($request)
    {
        $session = $request->getSession();
        if ($session->has('commande') !== true) {

            return true;

        }

    }

    public function controleSession2($request)
    {
        $session = $request->getSession();
        if ($session->has('commande') !== true || $session->has('client') !== true) {

            return true;

        }

    }

}