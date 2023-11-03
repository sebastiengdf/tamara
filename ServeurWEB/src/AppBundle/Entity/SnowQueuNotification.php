<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnowQueuNotification
 *
 * @ORM\Table(name="snow_queu_notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SnowQueuNotificationRepository")
 */
class SnowQueuNotification
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
     * @var bool
     *
     * @ORM\Column(name="issended", type="boolean")
     */
    private $issended;


    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Facture")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $facture;
 
 
    public function setFacture($facture)
    {
        $this->facture = $facture;
        
        return $this;
    }

    public function getFacture()
    {
       return $this->facture;
    }
    
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
     * Set issended
     *
     * @param boolean $issended
     *
     * @return SnowQueuNotification
     */
    public function setIssended($issended)
    {
        $this->issended = $issended;

        return $this;
    }

    /**
     * Get issended
     *
     * @return bool
     */
    public function getIssended()
    {
        return $this->issended;
    }
}

