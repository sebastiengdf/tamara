<?php

namespace CmsBundle\Event;

use CmsBundle\Entity\Page;
use Symfony\Component\EventDispatcher\Event;

class PagePreViewEvent extends Event
{
    const NAME = 'page.pre.view';

    protected $page;

    protected $locale;

    /**
     * PagePreViewEvent constructor.
     * @param $page
     * @param $locale
     */
    public function __construct(Page $page, $locale)
    {
        $this->page = $page;
        $this->locale = $locale;
    }

    /**
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }


}