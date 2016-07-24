<?php

namespace AppBundle\Security\Role;

use AppBundle\Entity\Role\RoleRepository;
use Symfony\Component\Security\Core\Role\RoleHierarchy as BaseRoleHierarchy;

class RoleHierarchy extends BaseRoleHierarchy
{
    /** @var RoleRepository  */
    protected $repository;

    /**
     * RoleHierarchy constructor.
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($this->buildRolesTree());
    }

    /**
     * @return array
     */
    private function buildRolesTree()
    {
        $hierarchy = [];

        foreach ($this->repository->findAll() as $role) {

            if ($role->getParent()) {
                if (!isset($hierarchy[$role->getParent()->getName()])) {
                    $hierarchy[$role->getParent()->getName()] = [];
                }
                $hierarchy[$role->getParent()->getName()][] = $role->getName();
            } else {
                if (!isset($hierarchy[$role->getName()])) {
                    $hierarchy[$role->getName()] = [];
                }
            }
        }
        return $hierarchy;
    }
}