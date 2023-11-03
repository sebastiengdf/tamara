<?php

namespace CmsBundle\Event;

use CmsBundle\Entity\PostInterface;
use Symfony\Component\EventDispatcher\Event;

class PostPreViewEvent extends Event
{

    const NAME = 'post.pre.view';

    /**
     * @var PostInterface
     */
    private $post;
    /**
     * @var
     */
    private $type;
    /**
     * @var
     */
    private $locale;

    public function __construct(PostInterface $post, $type, $locale)
    {
        $this->post = $post;
        $this->type = $type;
        $this->locale = $locale;
    }

    /**
     * @return PostInterface
     */
    public function getPost(): PostInterface
    {
        return $this->post;
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