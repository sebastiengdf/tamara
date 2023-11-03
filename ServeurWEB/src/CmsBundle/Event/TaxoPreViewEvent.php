<?php

namespace CmsBundle\Event;

use CmsBundle\Entity\TaxonomyInterface;
use Symfony\Component\EventDispatcher\Event;

class TaxoPreViewEvent extends Event
{
    const NAME = 'taxo.pre.view';

    protected $taxo;

    protected $type;

    protected $locale;

    /**
     * TaxoPreViewEvent constructor.
     * @param $locale
     * @param $type
     * @param $taxo
     */
    public function __construct(TaxonomyInterface $taxo, $type, $locale)
    {
        $this->taxo = $taxo;
        $this->locale = $locale;
        $this->type = $type;
    }

    /**
     * @return TaxonomyInterface
     */
    public function getTaxo(): TaxonomyInterface
    {
        return $this->taxo;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }


}