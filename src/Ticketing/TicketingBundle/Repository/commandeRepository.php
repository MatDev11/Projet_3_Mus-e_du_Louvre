<?php

namespace Ticketing\TicketingBundle\Repository;

/**
 * commandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class commandeRepository extends \Doctrine\ORM\EntityRepository
{
    public function myFindOne($id)
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->where('c.id = :id')
            ->setParameter('id', $id);

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function updatePrix($id,$prix)
    {

        //$qB = $this->createQueryBuilder('p');
          $qB = $this->getEntityManager()->createQueryBuilder();
          $qB ->update('TicketingBundle:commande', 'c')
              ->set('c.prix', '?1')
              ->where('c.id = ?2')
              ->setParameter(1, $prix)
              ->setParameter(2, $id);

          return $qB->getQuery();


       // $query = $this->_em->createQuery('UPDATE TicketingBundle:commande c set c.prix= 8 WHERE c.id = 1');
        //$query->getQuery()->execute();

       // return $results;
    }
}