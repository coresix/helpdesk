<?php

namespace AppBundle\Entity\TicketReply;

use AppBundle\Entity\Ticket\Ticket;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tickets_replies", indexes={
 *     @ORM\Index(name="createduser_idx", columns={"created_userid"})
 * })
 */
class TicketReply
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Ticket
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ticket\Ticket", inversedBy="replies")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id", nullable=false)
     */
    protected $ticket;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdTime;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User")
     * @ORM\JoinColumn(name="created_userid", referencedColumnName="id", nullable=false)
     */
    protected $createdUser;

    public function __construct(Ticket $ticket, User $user, $message)
    {
        $this->createdTime = new \DateTime();
        $this->ticket = $ticket;
        $this->createdUser = $user;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param Ticket $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param \DateTime $createdTime
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }

    /**
     * @return User
     */
    public function getCreatedUser()
    {
        return $this->createdUser;
    }

    /**
     * @param User $createdUser
     */
    public function setCreatedUser($createdUser)
    {
        $this->createdUser = $createdUser;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}