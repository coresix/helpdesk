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
        return parent::findAll();
    }
}