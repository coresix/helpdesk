<?php

namespace AppBundle\Entity\WorkflowTransition;


use AppBundle\Entity\Ticket\Ticket;
use AppBundle\Entity\Ticket\TicketManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class WorkflowTransitionManager
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
     * @var EntityRepository
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
     * @param $id
     *
     * @return WorkflowTransition
     */
    public function findById($id)
    {
        return $this->repo->find($id);
    }

    /**
     * @param Ticket $ticket
     * @param WorkflowTransition $transition
     * @param TicketManager $ticketManager
     */
    public function transitionTicket(Ticket $ticket, WorkflowTransition $transition, TicketManager $ticketManager)
    {
        if ($transition->getFromTicketStatus() === $ticket->getStatus()) {
            $ticket->setStatus($transition->getToTicketStatus());
            $ticketManager->saveTicket($ticket);
        }
    }

}