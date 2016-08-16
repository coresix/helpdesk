<?php

namespace AppBundle\Entity\Ticket;

use Doctrine\ORM\EntityRepository;

class TicketRepository extends EntityRepository
{

    /**
     * {@inheritdoc}
     *
     * @return Ticket
     */
    public function findById($id)
    {
        $query =  $this->createQueryBuilder('t')
              ->select('t')
              ->where('t.id = :id')->setParameter('id', $id)
              ->getQuery();

        $query->useResultCache(true)
              ->setResultCacheLifetime(120);

        return $query->getOneOrNullResult();
    }
}