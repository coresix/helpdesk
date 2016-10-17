<?php

namespace AppBundle\Entity\Ticket;

use AppBundle\Entity\Department\Department;
use AppBundle\ResourceId\ResourceIdEntity;
use AppBundle\Entity\TicketReply\TicketReply;
use AppBundle\Entity\TicketStatus\TicketStatus;
use AppBundle\Entity\TicketType\TicketType;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tickets", indexes={
 *     @ORM\Index(name="createduser_idx", columns={"created_userid"}),
 *     @ORM\Index(name="assignee_idx", columns={"assignee_userid"}),
 *     @ORM\Index(name="department_idx", columns={"department_id"}),
 *     @ORM\Index(name="status_idx", columns={"ticketstatus_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Ticket\TicketRepository")
 */
class Ticket implements ResourceIdEntity
{
    const HUMAN_ID_PREFIX = 'TKT';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Department
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Department\Department")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=false)
     */
    protected $department;

    /**
     * @var TicketStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TicketStatus\TicketStatus")
     * @ORM\JoinColumn(name="ticketstatus_id", referencedColumnName="id", nullable=false)
     */
    protected $status;


    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdTime;

    /**
     * @var TicketType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TicketType\TicketType")
     * @ORM\JoinColumn(name="tickettype_id", referencedColumnName="id", nullable=false)
     */
    protected $type;
    
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $priority;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $subject;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $message;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User")
     * @ORM\JoinColumn(name="assignee_userid", referencedColumnName="id", nullable=true)
     */
    protected $assignee;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User")
     * @ORM\JoinColumn(name="created_userid", referencedColumnName="id", nullable=false)
     */
    protected $createdUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $resolvedDate;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User")
     * @ORM\JoinColumn(name="resolved_userid", referencedColumnName="id", nullable=true)
     */
    protected $resolvedUser;

    /**
     * @var TicketReply[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TicketReply\TicketReply", mappedBy="ticket")
     */
    protected $replies;

    /**
     * Ticket constructor.
     * @param Department $department
     * @param TicketStatus $status
     * @param \DateTime $createdTime
     * @param TicketType $type
     * @param int $priority
     * @param string $subject
     * @param string $message
     * @param User $assignee
     * @param User $createdUser
     */
    public function __construct(
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
        $this->department = $department;
        $this->status = $status;
        $this->createdTime = $createdTime;
        $this->type = $type;
        $this->priority = $priority;
        $this->subject = $subject;
        $this->message = $message;
        $this->assignee = $assignee;
        $this->createdUser = $createdUser;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param Department $department
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;
    }

    /**
     * @return TicketStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param TicketStatus $status
     */
    public function setStatus(TicketStatus $status)
    {
        $this->status = $status;
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
    public function setCreatedTime(\DateTime $createdTime)
    {
        $this->createdTime = $createdTime;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
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

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param User $assignee
     */
    public function setAssignee(User $assignee)
    {
        $this->assignee = $assignee;
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
    public function setCreatedUser(User $createdUser)
    {
        $this->createdUser = $createdUser;
    }

    /**
     * @return TicketReply[]
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * @return \DateTime
     */
    public function getResolvedDate()
    {
        return $this->resolvedDate;
    }

    /**
     * @param \DateTime $resolvedDate
     */
    public function setResolvedDate(\DateTime $resolvedDate)
    {
        $this->resolvedDate = $resolvedDate;
    }

    /**
     * @return User
     */
    public function getResolvedUser()
    {
        return $this->resolvedUser;
    }

    /**
     * @param User $resolvedUser
     */
    public function setResolvedUser(User $resolvedUser)
    {
        $this->resolvedUser = $resolvedUser;
    }

    /**
     * @return TicketType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TicketType $type
     */
    public function setType(TicketType $type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceId()
    {
        return sprintf('%s-%s-%d',
            self::HUMAN_ID_PREFIX,
            $this->getDepartment()->getKey(),
            $this->getId()
        );
    }
}