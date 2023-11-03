<?php

namespace CmsBundle\Controller\Admin;

use CmsBundle\Entity\Link;
use CmsBundle\Entity\Menu;
use CmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{

    //------------------------------------------------------------------------------------------------------------------
    //	getLinksAction
    //------------------------------------------------------------------------------------------------------------------

    /**
     *  get all links from a menu and generate ul-li
     * @param \CmsBundle\Entity\Menu $menu
     * @return type
     */
    public function getLinksAction(Menu $menu)
    {

        $saveThis = $this;
        $em = $this->getDoctrine()->getManager();

        $linkRepo = $em->getRepository('CmsBundle:Link');
        $rootLink = $linkRepo->find($menu->getRootLink());

        $locale = $this->getParameter('locale');

        //  inject data in closure
        $dataNodes = $this->get('cms_nav.BuildMenu')->getDataNodes($rootLink, $menu);

        $nodes = $linkRepo->childrenHierarchy(
            $rootLink,
            false,
            array(
                'decorate'            => true,
                'html'                => true,
                'representationField' => 'name',
                'rootOpen'            => function ($tree) {
                    return (count($tree) && ($tree[0]['lvl'] == 1))
                        ? '<ol class="sortable">'
                        : '<ol>';
                },
                'rootClose'           => '</ol>',
                'childOpen'           => function ($node) {
                    return ($node['lvl'] == 1)
                        ? '<li class="mjs-nestedSortable-branch mjs-nestedSortable-expanded mjs-nestedSortable-leaf" id="menuItem_'.$node['id'].'">'
                        : '<li class="mjs-nestedSortable-branch mjs-nestedSortable-expanded" id="menuItem_'.$node['id'].'" style="display: list-item;">';
                },
                'childClose'          => '</li>',
                'nodeDecorator'       => function ($node) use ($dataNodes, $saveThis, $locale) {
                    if ($node) {
                        $urlEditLink = $saveThis->generateUrl(
                            'sonata_admin_set_object_field_value',
                            array(
                                'context'  => 'list',
                                'field'    => 'name',
                                'objectId' => $dataNodes[$node['id']]['id'],
                                'code'     => 'cms.admin.link',
                            )
                        );

                        $return = '<div class="" data-id="'.$dataNodes[$node['id']]['id'].'">';
                        $return .= '<span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"><span></span></span>';
                        $return .= '<span class="x-editable" data-type="text" data-value="'.$dataNodes[$node['id']]['name'].'" data-title="Name" data-pk="'.$dataNodes[$node['id']]['id'].'" data-url="'.$urlEditLink.'">'.$dataNodes[$node['id']]['name'].'</span>';
                        $return .= '<a class="btn btn-danger btn-edit-link" target="_blank" href="'.$dataNodes[$node['id']]['linkEdit'].'?tl='.$locale.'">Editer Le lien</a>';

                        if ($dataNodes[$node['id']]['hasPage']) {
                            $return .= '<a class="btn btn-success btn-edit-link" target="_blank" href="'.$dataNodes[$node['id']]['pageEdit'].'?tl='.$locale.'">Editer La page</a>';
                        }
//                        if ($dataNodes[$node['id']]['hasArticle']) {
//                            $return .= '<a class="btn btn-primary btn-edit-link" target="_blank" href="'.$dataNodes[$node['id']]['articleEdit'].'">Editer L\'article</a>';
//                        }
//                        if ($dataNodes[$node['id']]['hasCategory']) {
//                            $return .= '<a class="btn btn-warning btn-edit-link" target="_blank" href="'.$dataNodes[$node['id']]['categoryEdit'].'">Editer La catégorie</a>';
//                        }

                        $return .= '</div>';

                        return $return;
                    }
                },

            )
        );

        //<a  href="{{ path('admin_cms_page_page_edit', {'id' : node.page.id, 'menu': menu}) }}" ></a>

        return $this->render(
            'CmsBundle:Link:link_children_hierarchy.html.twig',
            array(
                'rootLink' => $rootLink,
                'nodes'    => $nodes,
                'menu'     => $menu,
            )
        );


    }

    public function createItemAction(Menu $menu) {

        return $this->render('@Cms/Menu/menu_edit_create_item.html.twig', array(
            'menu' => $menu,
            'pages' => $this->get('cms.manager.page')->findMany()
        ));
    }

    //------------------------------------------------------------------------------------------------------------------
    //	createLinkAction
    //------------------------------------------------------------------------------------------------------------------

    /**
     *  create a new link
     * @param type $menu
     * @return type
     * @Route("/%base_url_admin%/nav_admin_create_link/{menu}", name="nav_admin_create_link", options={"expose"=true})
     */
    public function createLinkAction($menu)
    {
        $em = $this->getDoctrine()->getManager();

        $menuObject = $em->getRepository('CmsBundle:Menu')->find($menu);

        $link = new Link;
        $link
            ->setName('Lien Libre')
            ->setLink(null)
            ->setParent($menuObject->getRootLink())
            ->setLinkType('LINK')
            ->setRootLink(false)
        ;

        $em->persist($link);

        $em->flush();

        return $this->redirect($this->generateUrl('admin_cms_menu_edit', array('id' => $menu)));
    }

    //------------------------------------------------------------------------------------------------------------------
    //	updateOrderLinkAction
    //------------------------------------------------------------------------------------------------------------------

    /**
     *  AJAX => Order link after drag & drop
     * @param Request $request
     * @return Response
     * @Route("/%base_url_admin%/nav_admin_update_order_link", name="nav_admin_update_order_link", options={"expose"=true})
     * @Method({"POST"})
     */
    public function updateOrderLinkAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();
            $linkRepo = $em->getRepository('CmsBundle:Link');

            $order = $request->request->get('order');


            $menuObject = array();
            foreach ($order as $key => $link)
            {
                $menuObject[$link["item_id"]] = $linkRepo->find((int) $link['item_id']);
            }

            foreach ($order as $key => $link)
            {
                if ($key != 0)
                {
                    $menuItem = $menuObject[$link["item_id"]];
                    $menuItem->setLvl($link["depth"]);
                    $menuItem->setLft($link["left"]);
                    $menuItem->setRgt($link["right"]);
                    if ($link["parent_id"] && $link["parent_id"] != 'none')
                    {
                        $menuItem->setParent($menuObject[$link["parent_id"]]);
                    }
                    else
                    {
                        $menuItem->setParent();
                    }
                }

                $em->flush();
            }
        }
        return new Response('Finish');
    }

    //------------------------------------------------------------------------------------------------------------------
    //	updatePageNameAction
    //------------------------------------------------------------------------------------------------------------------

    /**
     *  AJAX => Update Name with edit-inline
     * @param Request $request
     * @return Response
     * @Route("/%base_url_admin%/nav_admin_update_page_name", name="nav_admin_update_page_name", options={"expose"=true})
     * @Method({"POST"})
     */
    public function updatePageNameAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();

            $id = (int) str_replace('edit-message-', '', $this->getRequest()->request->get('id'));
            $value = $request->get('value');

            $link = $em->getRepository('CmsBundle:Link')->find($id);
            $link->setName($value);

            $em->flush();
            return new Response($value);
        }
    }

    /**
     * @param Menu $menu
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/%base_url_admin%/nav_admin_add_page/{page}/{menu}", name="nav_admin_add_page", options={"expose"=true})
     */
    public function addPageAction(Menu $menu, Page $page) {

        $em = $this->getDoctrine()->getManager();

        $link = new \CmsBundle\Entity\Link;
        $link
            ->setName($page->getName())
            ->setPage($page)
            ->setParent($menu->getRootLink())
            ->setLinkType('PAGE')
            ->setRootLink(false)
        ;

        $em->persist($link);

        $em->flush();

        return $this->redirect($this->generateUrl('admin_cms_menu_edit', array('id' => $menu->getId())));
    }

    //------------------------------------------------------------------------------------------------------------------
    //	deleteLinkAction
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @Route("/%base_url_admin%/nav_admin_delete_link/{linkId}/{menuId}", name="nav_admin_delete_link", options={"expose"=true})
     */

    public function deleteLinkAction($linkId, $menuId)
    {
        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('CmsBundle:Link')->find((int) $linkId);

        $em->remove($link);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_cms_menu_edit', array('id' => (int) $menuId)));
    }

}