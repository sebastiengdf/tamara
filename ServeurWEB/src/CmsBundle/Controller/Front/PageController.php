<?php

namespace CmsBundle\Controller\Front;

use CmsBundle\Controller\FrontControllerInterface;
use CmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller implements FrontControllerInterface
{

    /**
     * @Route("/{_locale}", name="homepage" , defaults={"_locale" = "%locale%"}, requirements={"_locale" = "%locales_routing%"}, options={"expose"=true})
     */
    public function homepageAction(Request $request, $_locale)
    {
        /** @var Page $page */
        $page = $this->get('cms.manager.page')->findOne(['id' => 1]);

        return $this->get('cms.render.page')->render($page, $_locale, $request);
    }

    /**
     * @Route("/{_locale}/{pageLink}", name="cms_page_show", requirements={"pageLink" = "([0-9]|[a-z]|[A-Z]|\/|-)*", "_locale" = "%locales_routing%"}, options={"expose"=true})
     */
    public function pageAction(Request $request, $_locale, $pageLink)
    {
        $folderSlug = $this->get('cms.folder_slug')->getFolderSlug($pageLink);

        /** @var Page $page */
        $page = $this->get('cms.manager.page')->findOne(
            ['folder' => $folderSlug['folder'], 'slug' => $folderSlug['slug']],
            ['admin' => false, '_locale' => $_locale]
        );

        if ($page->getId() == 1) {
            return $this->redirectToRoute('homepage', ['_locale' => $_locale]);
        }

        return $this->get('cms.render.page')->render($page, $_locale, $request, [], $pageLink);
    }


}