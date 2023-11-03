<?php

namespace CmsBundle\Controller\CPT;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WidgetController extends Controller
{

    public function categorysAction() {
        $path = $this->get("cms.template.hierarchy")->getBasePathShorcut();
        return $this->render("$path/widget:categorys.html.twig", [
           'categorys' => $this->get('taxo.category')->findMany(['published' => true])
        ]);
    }

    public function tagsAction() {
        $path = $this->get("cms.template.hierarchy")->getBasePathShorcut();
        return $this->render("$path/widget:tags.html.twig", [
           'tags' => $this->get('taxo.tag')->findMany(['published' => true])
        ]);
    }

}