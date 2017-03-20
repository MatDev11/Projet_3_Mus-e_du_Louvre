<?php


namespace Tests\ServiceTests;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ticketing\TicketingBundle\Entity\Visiteur;

class CalculePrixTotalTest extends WebTestCase
{
    private $client;
    private $CalculePrixTotal;




    public function testCalculeTotalPrix()
    {
        $this->client = self::createClient();
        $container = $this->client->getContainer();
        $this->CalculePrixTotal = $container->get('ticketing.CalculePrixTotal');

        $ticket1 = new Visiteur();
        $ticket1->setPrix('5');


        $ticket2 = new Visiteur();
        $ticket2->setPrix('10');


        $ticket3 = new Visiteur();
        $ticket3->setPrix('20');

        $tickets = new ArrayCollection();
        $tickets->add($ticket1);
        $tickets->add($ticket2);
        $tickets->add($ticket3);


        $price = $this->CalculePrixTotal->calculeTotalPrix($tickets);
        $this->assertEquals(35, $price);


    }

}