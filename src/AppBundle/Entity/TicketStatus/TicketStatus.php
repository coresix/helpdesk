<?php

namespace AppBundle\Entity\TicketStatus;

use AppBundle\Entity\WorkflowTransition\WorkflowTransition;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tickets_status")
 */
class TicketStatus
{
    const CATEGORY_TO_DO = 'to_do';
    const CATEGORY_IN_PROGRESS = 'in_progress';
    const CATEGORY_DONE = 'done';

    protected $enumCategories = [
        self::CATEGORY_TO_DO,
        self::CATEGORY_IN_PROGRESS,
        self::CATEGORY_DONE
    ];

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $category;

    /**
     * @var WorkflowTransition[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\WorkflowTransition\WorkflowTransition", mappedBy="fromTicketStatus")
     */
    protected $workflowTransitions;


    public function __construct($name, $category)
    {
        $this->workflowTransitions = new ArrayCollection();

        $this->setName($name);
        $this->setCategory($category);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return WorkflowTransition[]|ArrayCollection
     */
    public function getWorkflowTransitions()
    {
        return $this->workflowTransitions;
    }

    /**
     * @param string $name
     */
    protected function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param $category
     */
    protected function setCategory($category)
    {
        if (!in_array($category, $this->enumCategories, true)){
            throw new \InvalidArgumentException('Invalid category');
        }

        $this->category = $category;
    }
}