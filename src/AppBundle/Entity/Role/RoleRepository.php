<?php

namespace AppBundle\Entity\Role;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{

    /**
     * {@inheritdoc}
     *
     * @return Role[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->getQuery()
            ->useResultCache(true)
            ->setResultCacheLifetime(120)
            ->getResult();
    }
}