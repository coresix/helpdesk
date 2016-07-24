<?php

namespace AppBundle\Controller;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter;

trait SecurityTrait
{

    /**
     * @return TokenInterface
     */
    protected function getSecurityToken()
    {
        return $this->get('security.token_storage')->getToken();
    }

    /**
     * @return RoleHierarchyVoter
     */
    public function getRoleHierarchyVoter()
    {
        return new RoleHierarchyVoter($this->get('security.role_hierarchy'));
    }

    /**
     * Gets a container service by its id.
     *
     * @param string $id The service id
     *
     * @return object The service
     */
    abstract protected function get($id);
}