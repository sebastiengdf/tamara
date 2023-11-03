<?php

namespace WorkflowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkflowTransition
 *
 * @ORM\Table(name="workflow_transition")
 * @ORM\Entity(repositoryClass="WorkflowBundle\Repository\WorkflowTransitionRepository")
 */
class WorkflowTransition
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true, unique=false)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="WorkflowBundle\Entity\WorkflowStep")
     * @ORM\JoinColumn(name="source_step", referencedColumnName="id", nullable=true)
     */
    protected $sourceStep;

    /**
     * @ORM\ManyToOne(targetEntity="WorkflowBundle\Entity\WorkflowStep")
     * @ORM\JoinColumn(name="target_step", referencedColumnName="id", nullable=true)
     */
    protected $targetStep;

    /**
     * @ORM\OneToMany(targetEntity="WorkflowBundle\Entity\WorkflowCondition", mappedBy="workflowTransition", cascade={"persist", "remove"})
     */
    protected $workflowConditions;

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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return WorkflowTransition
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set sourceStep
     *
     * @param \WorkflowBundle\Entity\WorkflowStep $sourceStep
     *
     * @return WorkflowTransition
     */
    public function setSourceStep(\WorkflowBundle\Entity\WorkflowStep $sourceStep = null)
    {
        $this->sourceStep = $sourceStep;

        return $this;
    }

    /**
     * Get sourceStep
     *
     * @return \WorkflowBundle\Entity\WorkflowStep
     */
    public function getSourceStep()
    {
        return $this->sourceStep;
    }

    /**
     * Set targetStep
     *
     * @param \WorkflowBundle\Entity\WorkflowStep $sourceStep
     *
     * @return WorkflowTransition
     */
    public function setTargetStep(\WorkflowBundle\Entity\WorkflowStep $targetStep = null)
    {
        $this->targetStep = $targetStep;

        return $this;
    }

    /**
     * Get targetStep
     *
     * @return \WorkflowBundle\Entity\WorkflowStep
     */
    public function getTargetStep()
    {
        return $this->targetStep;
    }

    /**
     * Add workflowCondition
     *
     * @param \WorkflowBundle\Entity\WorkflowCondition $workflowCondition
     *
     * @return WorkflowTransition
     */
    public function addWorkflowCondition(\WorkflowBundle\Entity\WorkflowCondition $workflowCondition)
    {
        $this->workflowConditions[] = $workflowCondition;
		$workflowCondition->setWorkflowTransition($this);
        return $this;
    }

    /**
     * Remove workflowCondition
     *
     * @param \WorkflowBundle\Entity\WorkflowCondition $workflowCondition
     */
    public function removeWorkflowCondition(\WorkflowBundle\Entity\WorkflowCondition $workflowCondition)
    {
        $this->workflowConditions->removeElement($workflowCondition);
        $workflowCondition->setWorkflowTransition(null);
    }

    /**
     * Get workflowCondition
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkflowConditions()
    {
        return $this->workflowConditions;
    }
}
