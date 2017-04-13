<?php

namespace Tests\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{

//Formulaire de réservation  Ok
    public function testFormCommandeOk()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Reservation/');
        $form = $crawler->selectButton('commande[reserver]')->form();
        $client->submit($form, ['commande[date_commande]' => '28/10/2017',
            'commande[qte_place]' => '1',
            'commande[type_tarif]' => false]);
        $this->assertTrue($client->getResponse()->isRedirect('/Reservation/Ticket'));

       /* $crawler= $client->followRedirect();

        $form = $crawler->selectButton('groupe_visiteur[Suivant]')->form();
        $client->submit($form, ['groupe_visiteur[visiteur-1][nom]' => 'Renard',
            'groupe_visiteur[visiteur-1][prenom]' => 'Julien',
            'groupe_visiteur[visiteur-1][pays]' => 'FR',
            'groupe_visiteur[visiteur-1][dateDeNaissance][day]' => '12',
            'groupe_visiteur[visiteur-1][dateDeNaissance][month]' => '02',
            'groupe_visiteur[visiteur-1][dateDeNaissance][year]' => '1990',
            'groupe_visiteur[visiteur-1][reduction]' => false]);
        $this->assertTrue($client->getResponse()->isRedirect('/Reservation/Paiement'));*/

    }


    //Formulaire de réservation  No
    public function testFormCommandeNoJourPasse()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Reservation/');
        $form = $crawler->selectButton('commande[reserver]')->form();
        $client->submit($form, ['commande[date_commande]' => '28/02/2017',
            'commande[qte_place]' => '3',
            'commande[type_tarif]' => false]);
        $this->assertFalse($client->getResponse()->isRedirect('/Reservation/Ticket'));

    }

    //Formulaire de réservation  No
    public function testFormCommandeNoMardi()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Reservation/');
        $form = $crawler->selectButton('commande[reserver]')->form();
        $client->submit($form, ['commande[date_commande]' => '04/04/2017',//Mardi
            'commande[qte_place]' => '3',
            'commande[type_tarif]' => false]);
        $this->assertFalse($client->getResponse()->isRedirect('/Reservation/Ticket'));

    }

    //Formulaire de réservation  No
    public function testFormCommandeNoDimanche()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Reservation/');
        $form = $crawler->selectButton('commande[reserver]')->form();
        $client->submit($form, ['commande[date_commande]' => '16/04/2017',//Dimanche
            'commande[qte_place]' => '3',
            'commande[type_tarif]' => false]);
        $this->assertFalse($client->getResponse()->isRedirect('/Reservation/Ticket'));
    }



    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(

            array('/Pages/CGV'),
            array('/Pages/MentionLegales'),
            array('/Reservation/'),
            //  array('/Reservation/Ticket'),
            // array('/Reservation/Paiement'),
            //  array('/Reservation/Recapitulatif_Paiement'),


        );
    }

}
