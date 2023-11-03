<?php

namespace CmsBundle\Util;

trait ClassDetector
{
    public function getType()
    {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }
}