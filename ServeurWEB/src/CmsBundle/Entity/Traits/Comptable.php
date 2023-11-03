<?php


namespace CmsBundle\Entity\Traits;


trait Comptable
{

    /**
     * @var integer
     * @Gedmo\Translatable
     * @ORM\Column(name="count", type="integer", nullable=true)
     */
    protected $count = 0;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return object
     */
    public function setCount(int $count)
    {
        $this->count = $count;

        return $this;
    }





}