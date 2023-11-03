<?php

namespace CmsBundle\Manager;

class MenuManager extends BaseManager
{


    public function findSlugs()
    {
        $slugs = array();
        $menus = $this->repo->findAll();
        foreach ($menus as $menu) {
            $slugs[] = $menu->getSlug();
        }

        return $slugs;
    }

    public function find($slug)
    {
        return $this->repo->findOneByUniqueSlug($slug);
    }

    public function findAll() {
        return $this->repo->findAll();
    }


}