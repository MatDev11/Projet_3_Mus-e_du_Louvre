<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 23/02/2017
 * Time: 14:31
 */

namespace Ticketing\TicketingBundle\Service;


use Doctrine\ORM\EntityManagerInterface;

class PersistEntity
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persistEntity($visiteurs, $commande, $client)
    {

        foreach ($visiteurs as $visiteur) {
            $this->em->persist($visiteur);
        }
        $this->em->persist($commande);
        $this->em->persist($client);
        $this->em->flush();

    }


}