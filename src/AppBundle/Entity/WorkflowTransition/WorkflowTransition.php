<?php

namespace AppBundle\Entity\WorkflowTransition;

use AppBundle\Entity\TicketStatus\TicketStatus;
use AppBundle\Entity\Workflow\Workflow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="workflows_transitions")
 */
class WorkflowTransition
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
     * @var Workflow
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Workflow\Workflow")
     * @ORM\JoinColumn(name="workflow_id", referencedColumnName="id", nullable=false)
     */
    protected $workflow;

    /**
     * @var TicketStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TicketStatus\TicketStatus", inversedBy="workflowTransitions")
     * @ORM\JoinColumn(name="from_ticketstatus_id", referencedColumnName="id", nullable=false)
     */
    protected $fromTicketStatus;

    /**
     * @var TicketStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TicketStatus\TicketStatus")
     * @ORM\JoinColumn(name="to_ticketstatus_id", referencedColumnName="id", nullable=false)
     */
    protected $toTicketStatus;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * WorkflowTransition constructor.
     * @param Workflow $workflow
     * @param TicketStatus $fromTicketStatus
     * @param TicketStatus $toTicketStatus
     * @param string $description
     */
    public function __construct(
        Workflow $workflow,
        TicketStatus $fromTicketStatus,
        TicketStatus $toTicketStatus,
        $description
    ) {
        $this->workflow = $workflow;
        $this->fromTicketStatus = $fromTicketStatus;
        $this->toTicketStatus = $toTicketStatus;
        $this->description = $description;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Workflow
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * @param Workflow $workflow
     */
    public function setWorkflow(Workflow $workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * @return TicketStatus
     */
    public function getFromTicketStatus()
    {
        return $this->fromTicketStatus;
    }

    /**
     * @param TicketStatus $fromTicketStatus
     */
    public function setFromTicketStatus(TicketStatus $fromTicketStatus)
    {
        $this->fromTicketStatus = $fromTicketStatus;
    }

    /**
     * @return TicketStatus
     */
    public function getToTicketStatus()
    {
        return $this->toTicketStatus;
    }

    /**
     * @param TicketStatus $toTicketStatus
     */
    public function setToTicketStatus(TicketStatus $toTicketStatus)
    {
        $this->toTicketStatus = $toTicketStatus;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}