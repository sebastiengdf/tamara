<?php
/**
 * Created by PhpStorm.
 * User: serverpilot
 * Date: 03/06/17
 * Time: 09:59
 */

namespace CmsBundle\Entity\Traits;


trait Authorable
{

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="text", nullable=true)
     */
    protected $author;

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Authorable
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }



}