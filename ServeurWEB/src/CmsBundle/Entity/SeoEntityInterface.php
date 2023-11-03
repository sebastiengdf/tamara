<?php

namespace CmsBundle\Entity;

interface SeoEntityInterface
{
    public function getName();
    public function setTitle($title);
    public function getTitle();
    public function setH1($H1);
    public function getH1();
    public function setMetaDescription($metaDescription);
    public function getMetaDescription();
    public function setMetaKeyword($metaKeyword);
    public function getMetaKeyword();
    public function setOtherMeta($otherMeta);
    public function getOtherMeta();
}