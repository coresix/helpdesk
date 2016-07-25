<?php

namespace AppBundle\Entity\User;


use AppBundle\HumanId\EntityHumanIdProvider;

class UserHumanIdProvider implements EntityHumanIdProvider
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsSearching()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
        return User::HUMAN_ID_PREFIX;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityIdentityField()
    {
        return 'id';
    }
}