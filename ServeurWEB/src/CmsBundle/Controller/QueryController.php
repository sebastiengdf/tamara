<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class QueryController
 * @package CmsBundle\Controller
 */
class QueryController extends Controller
{
    /**
     * @param $cpt
     * @param $template
     * @param bool $cache
     * @param int $cacheTime
     * @param array $criterias
     * @param array $orders
     * @param array $numbers
     * @param array $options
     * @param string $function
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function queryAction($cpt, $template, bool $cache = false, int $cacheTime = 0, $criterias = [], $orders = [], $numbers = [], $options = [], $function = 'findMany')
    {
        $criterias['published'] = true;
        $options['_locale'] = $this->get('request_stack')->getCurrentRequest()->getLocale();

        $response = $this->render(
                $this->get('cms.template.hierarchy')->getBasePathShorcut().'/query:'.$template.'.html.twig',
                [
                    'items' => $this->get('cpt.'.$cpt)->$function($criterias, $orders, $numbers, $options)
                ]
            );

        if($cache) {
            $response->setSharedMaxAge($cacheTime);
        }

        return $response;
    }
}