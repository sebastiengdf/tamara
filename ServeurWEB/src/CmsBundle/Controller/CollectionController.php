<?php

namespace CmsBundle\Controller;

use CmsBundle\Entity\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CollectionController extends Controller
{

    public function showAction($slug)
    {
        /** @var Collection $collection */
        $collection = $this->get('cms.manager.collection')->findOne(['uniqueSlug' => $slug]);
        $items = $this->get('cpt.item')->findMany(['sliderUniqueSlug' => $slug]);

        $template = (empty($collection->getContent())) ? $collection->getVue() : '@Cms/Collection/collection_default.html.twig';

        $response = $this->render(
            $template,
            [
                'collection' => $collection,
                'items' => $items,
                'slug'   => $slug,
            ]
        );

        if ($collection->getCache()) {
            $response->setSharedMaxAge($collection->getCacheTime());
        }

        return $response;
    }

}