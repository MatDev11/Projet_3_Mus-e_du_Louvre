<?php


namespace Tests\ServiceTests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CalculePrixTest extends WebTestCase
{
    private $client;
    private $CalculePrix;

    protected function setUp()
    {
        $this->client = self::createClient();
        $container = $this->client->getContainer();
        $this->CalculePrix = $container->get('ticketing.CalculePrix');
    }

    public function testPrixTicket()
    {
        // Tarif normal
        $date = \Datetime::createFromFormat('d/m/Y', '31/12/1986');
        $price = $this->CalculePrix->prixTicket($date, false, false);
        $this->assertEquals(16, $price);

        // Tarif réduit
        $price = $this->CalculePrix->prixTicket($date, true, false);
        $this->assertEquals(10, $price);

        // Tarif demi-journée
        $price = $this->CalculePrix->prixTicket($date, false, true);
        $this->assertEquals(8, $price);

        //Tarif Senior
        $date = \Datetime::createFromFormat('d/m/Y', '31/12/1950');
        $price = $this->CalculePrix->prixTicket($date, false, false);
        $this->assertEquals(12, $price);

        //Tarif moins de 4 ans
        $date = \Datetime::createFromFormat('d/m/Y', '31/12/2015');
        $price = $this->CalculePrix->prixTicket($date, false, false);
        $this->assertEquals(0, $price);

        // Tarif enfant
        $date = \Datetime::createFromFormat('d/m/Y', '31/12/2010');
        $price = $this->CalculePrix->prixTicket($date, false, false);
        $this->assertEquals(8, $price);

    }

}