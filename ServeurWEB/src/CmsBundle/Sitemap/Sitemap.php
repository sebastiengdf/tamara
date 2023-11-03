<?php

namespace CmsBundle\Sitemap;

use CmsBundle\Entity\AbstractPost;
use CmsBundle\Entity\AbstractTaxonomy;
use CmsBundle\Entity\ListSeo;
use CmsBundle\Entity\Page;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Sitemap
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function generate()
    {
        $urls = [];

        $locales = $this->container->getParameter('locales');
        $default_locale = $this->container->getParameter('locale');
        $taxos = $this->container->getParameter('taxo');
        $cpts = $this->container->getParameter('cpt');

        foreach ($locales as $locale) {
	        $isDefaultLocale = $locale == $default_locale;

            $pages = $this->container->get('cms.manager.page')->findMany(
                [],
                [],
                [],
                ['_locale' => $locale]
            );
            /** @var Page $page */
            foreach ($pages as $page) {
	            if ( $isDefaultLocale ) {
		            $published  = $page->getPublished();
		            $notIndexed = $page->getNoIndex();
	            } else {
		            $published  = $page->getTranslation( 'published', $locale );
		            $notIndexed = $page->getTranslation( 'noIndex', $locale );
	            }

	            if ( ! is_null( $published ) and $published and ! $notIndexed ) {
                    $urls[] = [
                        'loc'        => $this->container->get('router')->generate('cms_page_show', ['_locale' => $locale, 'pageLink' => $page->getUrl()], UrlGeneratorInterface::ABSOLUTE_URL),
                        'lastmod'    => $page->getUpdated()->format('Y-m-d'),
                        'changefreq' => 'daily',
                        'priority'   => 0.8,
                    ];
                }

            }

            $lists = $this->container->get('cms.manager.list_seo')->findMany(
                [],
                [],
                [],
                ['_locale' => $locale]
            );

	        $accessiblesLists = [];

            /** @var ListSeo $list */
            foreach ($lists as $list) {
	            if ( $isDefaultLocale ) {
		            $notIndexed = $list->getNoIndex();
	            } else {
		            $notIndexed = $list->getTranslation( 'noIndex', $locale );
	            }

	            if ( ! is_null( $notIndexed ) and ! $notIndexed ) {
		            if ( $isDefaultLocale ) {
			            $slug = $list->getSlug();
		            } else {
			            $slug = $list->getTranslation( 'slug', $locale );
		            }
		            if ( ! is_null( $slug ) ) {
			            $accessiblesLists[] = $slug;
			            $urls[]             = [
				            'loc'        => $this->container->get( 'router' )->generate( 'cms_list_show', [
					            '_locale' => $locale,
					            'type'    => $slug
				            ], UrlGeneratorInterface::ABSOLUTE_URL ),
				            'lastmod'    => $list->getUpdated()->format( 'Y-m-d' ),
				            'changefreq' => 'daily',
				            'priority'   => 0.8,
			            ];
		            }
	            }
            }


            foreach ($taxos as $taxo) {
                $taxoItems = $this->container->get('taxo.'.$taxo)->findMany(
                    [],
                    [],
                    [],
                    ['_locale' => $locale]
                );
                /** @var AbstractTaxonomy $taxoItem */
                foreach ($taxoItems as $taxoItem) {
	                if ( $isDefaultLocale ) {
		                $published  = $taxoItem->getPublished();
		                $notIndexed = $taxoItem->getNoIndex();
	                } else {
		                $published  = $taxoItem->getTranslation( 'published', $locale );
		                $notIndexed = $taxoItem->getTranslation( 'noIndex', $locale );
	                }
	                if ( ! is_null( $published ) and $published and ! $notIndexed ) {
		                if ( $isDefaultLocale ) {
			                $slug = $taxoItem->getSlug();
		                } else {
			                $slug = $taxoItem->getTranslation( 'slug', $locale );
		                }
		                if ( ! is_null( $slug ) ) {
			                $urls[] = [
				                'loc'        => $this->container->get( 'router' )->generate(
					                'cms_taxo_show',
					                [ '_locale' => $locale, 'type' => $taxo, 'slug' => $slug ],
					                UrlGeneratorInterface::ABSOLUTE_URL
				                ),
				                'lastmod'    => $taxoItem->getUpdated()->format( 'Y-m-d' ),
				                'changefreq' => 'daily',
				                'priority'   => 0.8,
			                ];
		                }
                    }
                }
            }

	        foreach ( $cpts as $cpt ) {
		        if ( in_array( $cpt, $accessiblesLists ) ) {
			        $items = $this->container->get( 'cpt.' . $cpt )->findMany(
				        [],
				        [],
				        [],
				        [ '_locale' => $locale ]
			        );
			        /** @var AbstractPost $item */
			        foreach ( $items as $item ) {
				        if ( $isDefaultLocale ) {
					        $published  = $item->getPublished();
					        $notIndexed = $item->getNoIndex();
				        } else {
					        $published  = $item->getTranslation( 'published', $locale );
					        $notIndexed = $item->getTranslation( 'noIndex', $locale );
				        }
				        if ( ! is_null( $published ) and $published and ! $notIndexed ) {
					        if ( $isDefaultLocale ) {
						        $slug = $item->getSlug();
					        } else {
						        $slug = $item->getTranslation( 'slug', $locale );
					        }
					        if ( ! is_null( $slug ) ) {
						        $urls[] = [
							        'loc'        => $this->container->get( 'router' )->generate(
								        'cms_post_show',
								        [ '_locale' => $locale, 'type' => $cpt, 'slug' => $slug ],
								        UrlGeneratorInterface::ABSOLUTE_URL
							        ),
							        'lastmod'    => $item->getUpdated()->format( 'Y-m-d' ),
							        'changefreq' => 'daily',
							        'priority'   => 0.8,
						        ];
					        }
				        }
			        }
		        }
            }

        }

        return $urls;


    }

}