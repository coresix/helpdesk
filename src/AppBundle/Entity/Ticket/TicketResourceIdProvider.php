<?php
namespace AppBundle\Entity\Ticket;


use AppBundle\ResourceId\EntityResourceProvider;

class TicketResourceIdProvider implements EntityResourceProvider
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return Ticket::class;
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
        return Ticket::HUMAN_ID_PREFIX;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityIdentityField()
    {
        return 'id';
    }
}