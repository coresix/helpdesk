<?php

namespace AppBundle\Entity\Ticket;

use AppBundle\Entity\Department\Department;
use AppBundle\Entity\TicketStatus\TicketStatus;
use AppBundle\Entity\TicketType\TicketType;
use AppBundle\Entity\User\User;
use AppBundle\Event\Ticketing\CreatedUpdatedEvent;
use AppBundle\ResourceId\ResourceIdResolver;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TicketManager
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
     * @var TicketRepository
     */
    protected $repo;


    /**
     * Provides helper functions for dealing with human ids.
     *
     * @var ResourceIdResolver
     */
    protected $humanIdHelper;

    /**
     * The Fully-Qualified Class Name for the entity
     *
     * @var string
     */
    protected $class;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EntityManager $em,
        ResourceIdResolver $humanIdHelper,
        $class
    )
    {
        $this->dispatcher       = $dispatcher;
        $this->em               = $em;
        $this->humanIdHelper    = $humanIdHelper;
        $this->class            = $class;
        $this->repo             = $em->getRepository($this->class);
    }

    /**
     * @param Department $department
     * @param TicketStatus $status
     * @param \DateTime $createdTime
     * @param TicketType $type
     * @param $priority
     * @param $subject
     * @param $message
     * @param User|null $assignee
     * @param User $createdUser
     * @return Ticket
     */
    public function createTicket(
        Department $department,
        TicketStatus $status,
        \DateTime $createdTime,
        TicketType $type,
        $priority,
        $subject,
        $message,
        User $assignee = null,
        User $createdUser
    ) {
        $class = $this->class;
        $ticket = new $class(
            $department,
            $status,
            $createdTime,
            $type,
            $priority,
            $subject,
            $message,
            $assignee,
            $createdUser
        );

        return $ticket;
    }

    /**
     * Saves a ticket.
     *
     * @param Ticket $ticket The ticket.
     */
    public function saveTicket(Ticket $ticket)
    {
        $event = ($ticket->getId() === null) ? 'app_bundle.ticket.created' : 'app_bundle.ticket.updated';

        $this->em->persist($ticket);
        $this->em->flush();

        $this->dispatcher->dispatch($event, new CreatedUpdatedEvent($ticket));
    }

    /**
     * Finds a ticket by its human id.
     *
     * @param string $humanId The Human Id
     *
     * @return null|Ticket
     */
    public function findByHumanId($humanId)
    {
        if ($this->humanIdHelper->getEntityTypeFromResourceId($humanId) !== $this->class) {
            throw new \InvalidArgumentException();
        }

        $id = $this->humanIdHelper->getEntityIdFromResourceId($humanId);

        return $this->repo->find($id);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Ticket[]
     */
    public function find(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->repo->findBy($criteria, $orderBy, $limit, $offset);
    }
}