<?php

namespace AppBundle\Event\Ticketing;

use AppBundle\Entity\Ticket\Ticket;
use Symfony\Component\EventDispatcher\Event;

class CreatedUpdatedEvent extends Event
{
    /** @var  Ticket */
    protected $ticket;

    /**
     * ReplyEvent constructor.
     * @param Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}