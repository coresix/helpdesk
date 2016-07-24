<?php

namespace AppBundle\Event\Ticketing;

use AppBundle\Entity\Ticket\Ticket;
use AppBundle\Entity\TicketReply\TicketReply;
use Symfony\Component\EventDispatcher\Event;

class ReplyEvent extends Event
{

    /** @var  Ticket */
    protected $ticket;
    /** @var  TicketReply */
    protected $reply;

    /**
     * ReplyEvent constructor.
     * @param Ticket $ticket
     * @param TicketReply $reply
     */
    public function __construct(Ticket $ticket, TicketReply $reply)
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @return TicketReply
     */
    public function getReply()
    {
        return $this->reply;
    }
}