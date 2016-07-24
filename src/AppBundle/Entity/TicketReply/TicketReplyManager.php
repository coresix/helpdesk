<?php

namespace AppBundle\Entity\TicketReply;

use AppBundle\Entity\Ticket\Ticket;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\UserRepository;
use AppBundle\Event\Ticketing\ReplyEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TicketReplyManager
{

    /**
     * Holds the Symfony2 event dispatcher service
     */
    protected $dispatcher;

    /**
     * Holds the Doctrine entity manager for database interaction
     * @var EntityManager
     */
    protected $em;

    /**
     * Entity-specific repository
     *
     * @var UserRepository
     */
    protected $repo;


    /**
     * The Fully-Qualified Class Name for the entity
     *
     * @var string
     */
    protected $class;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EntityManager $em,
        $class
    )
    {
        $this->dispatcher       = $dispatcher;
        $this->em               = $em;
        $this->class            = $class;
        $this->repo             = $em->getRepository($class);
    }

    /**
     * @param Ticket $ticket
     * @param User $user
     * @param string $message
     * @return TicketReply
     */
    public function createReply(Ticket $ticket, User $user, $message)
    {
        $class = $this->class;
        /** @var TicketReply $reply */
        $reply = new $class($ticket, $user, $message);

        return $reply;
    }

    /**
     * @param TicketReply $reply
     */
    public function addReply(TicketReply $reply)
    {
        $this->em->persist($reply);
        $this->em->flush();

        $this->dispatcher->dispatch('app_bundle.ticket.reply_added', new ReplyEvent($reply->getTicket(), $reply));
    }
}