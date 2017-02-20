<?php

namespace Ticketing\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TicketingBundle:Default:Commande.html.twig');
    }
}
