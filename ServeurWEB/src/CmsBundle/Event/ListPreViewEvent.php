<?php

namespace CmsBundle\Event;

use CmsBundle\Entity\ListSeo;
use Symfony\Component\EventDispatcher\Event;

class ListPreViewEvent extends Event
{

    const NAME = 'list.pre.view';

    protected $list;

    protected $locale;

    /**
     * ListPreViewEvent constructor.
     * @param $list
     * @param $locale
     */
    public function __construct(ListSeo $list, $locale)
    {
        $this->list = $list;
        $this->locale = $locale;
    }

    /**
     * @return ListSeo
     */
    public function getList(): ListSeo
    {
        return $this->list;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }


}