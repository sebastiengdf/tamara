<?php

namespace WorkflowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkflowCondition
 *
 * @ORM\Table(name="workflow_condition")
 * @ORM\Entity(repositoryClass="WorkflowBundle\Repository\WorkflowConditionRepository")
 */
class WorkflowCondition
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="WorkflowBundle\Entity\WorkflowTransition")
     * @ORM\JoinColumn(name="workflow_transition", referencedColumnName="id", nullable=true)
     */
    protected $workflowTransition;

    /**
     * @var string
     *
     * @ORM\Column(name="condition_type", type="string", length=255, nullable=true, unique=false)
     */
    private $conditionType;

    /**
     * @var string
     *
     * @ORM\Column(name="variable_name", type="string", length=255, nullable=true, unique=false)
     */
    private $variableName;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set workflowTransition
     *
     * @param \WorkflowBundle\Entity\WorkflowTransition $workflowTransition
     *
     * @return WorkflowCondition
     */
    public function setWorkflowTransition(\WorkflowBundle\Entity\WorkflowTransition $workflowTransition = null)
    {
        $this->workflowTransition = $workflowTransition;

        return $this;
    }

    /**
     * Get workflowTransition
     *
     * @return \WorkflowBundle\Entity\WorkflowTransition
     */
    public function getWorkflowTransition()
    {
        return $this->workflowTransition;
    }

   /**
     * Set conditionType
     *
     * @param string $conditionType
     *
     * @return WorkflowCondition
     */
    public function setConditionType($conditionType)
    {
        $this->conditionType = $conditionType;

        return $this;
    }

    /**
     * Get conditionType
     *
     * @return string
     */
    public function getConditionType()
    {
        return $this->conditionType;
    }

    /**
     * Set variableName
     *
     * @param string $variableName
     *
     * @return WorkflowCondition
     */
    public function setVariableName($variableName)
    {
        $this->variableName = $variableName;

        return $this;
    }

    /**
     * Get variableName
     *
     * @return string
     */
    public function getVariableName()
    {
        return $this->variableName;
    }
}
