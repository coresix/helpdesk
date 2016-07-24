<?php
namespace AppBundle\Entity\Ticket;


use AppBundle\HumanId\EntityHumanIdProvider;

class TicketHumanIdProvider implements EntityHumanIdProvider
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
}