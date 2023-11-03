<?php

namespace WorkflowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkflowStep
 *
 * @ORM\Table(name="workflow_step")
 * @ORM\Entity(repositoryClass="WorkflowBundle\Repository\WorkflowStepRepository")
 */
class WorkflowStep
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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true, unique=true)
     */
    private $code;

    
    /**
     * @var string
     *
     * @ORM\Column(name="baseRouteName", type="string", length=255, nullable=true, unique=false)
     */
    private $baseRouteName;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="baseRoutePattern", type="string", length=255, nullable=true, unique=false)
     */
    private $baseRoutePattern;
    
    /**
     * @ORM\OneToMany(targetEntity="WorkflowBundle\Entity\WorkflowTransition", mappedBy="sourceStep", cascade={"persist", "remove"})
     */
    protected $workflowTransitions;

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
     * @return WorkflowStep
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
     * Set code
     *
     * @param string $code
     *
     * @return WorkflowStep
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add workflowTransition
     *
     * @param \WorkflowBundle\Entity\WorkflowTransition $workflowTransition
     *
     * @return WorkflowStep
     */
    public function addWorkflowTransition(\WorkflowBundle\Entity\WorkflowTransition $workflowTransition)
    {
        $this->workflowTransitions[] = $workflowTransition;
		$workflowTransition->setWorkflowStep($this);
        return $this;
    }

    /**
     * Remove workflowTransition
     *
     * @param \WorkflowBundle\Entity\WorkflowTransition $workflowTransition
     */
    public function removeWorkflowTransition(\WorkflowBundle\Entity\WorkflowTransition $workflowTransition)
    {
        $this->workflowTransitions->removeElement($workflowTransition);
        $workflowTransition->setWorkflowStep(null);
    }

    /**
     * Get workflowTransition
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkflowTransitions()
    {
        return $this->workflowTransitions;
    }
	public function getBaseRouteName() {
		return $this->baseRouteName;
	}
	public function setBaseRouteName($baseRouteName) {
		$this->baseRouteName = $baseRouteName;
		return $this;
	}
	public function getBaseRoutePattern() {
		return $this->baseRoutePattern;
	}
	public function setBaseRoutePattern($baseRoutePattern) {
		$this->baseRoutePattern = $baseRoutePattern;
		return $this;
	}
	
   public function __toString(): string{
   	return $this->libelle;
   }
}
