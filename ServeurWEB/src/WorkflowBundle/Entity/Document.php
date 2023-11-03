<?php

namespace WorkflowBundle\Entity;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;
use WorkflowBundle\Entity\WorkflowStep;

/** @MappedSuperclass */
class Document
{    
    /**
     * @ORM\ManyToOne(targetEntity="WorkflowBundle\Entity\WorkflowStep")
     * @ORM\JoinColumn(name="step", referencedColumnName="id", nullable=true)
     */
    protected $step;

    /**
     * Set step
     *
     * @param \WorkflowBundle\Entity\WorkflowStep $step
     *
     * @return Document
     */
    public function setStep(\WorkflowBundle\Entity\WorkflowStep $step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return \WorkflowBundle\Entity\WorkflowStep
     */
    public function getStep()
    {
        return $this->step;
    }
}
