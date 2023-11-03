<?php

namespace CmsBundle\Twig;

use CmsBundle\Entity\AbstractPost;
use CmsBundle\Entity\AbstractTaxonomy;
use CmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bridge\Twig\Extension\AssetExtension;

class LocaleSwitcher extends \Twig_Extension
{

    protected $router;
    protected $asset;
    protected $locales;

    function __construct(Router $router, AssetExtension $asset)
    {
        $this->router = $router;
        $this->asset = $asset;
    }

    public function setLocales($locales)
    {
        $this->locales = $locales;
    }

    public function getName()
    {
        return 'localeSwitcher';
    }

    public function getFunctions()
    {
        return array(
            'localeSwitcher' => new \Twig_Function_Method($this, 'localeSwitcher'),
        );
    }

    public function localeSwitcher($type, $data)
    {
        switch ($type) {
            case 'page' :
                return $this->getLocalePage($data);
            case 'post' :
                return $this->getLocalePost($data['object'], $data['type']);
            case 'taxo' :
                return $this->getLocaleTaxo($data['object'], $data['type']);
            case 'list' :
                return $this->getLocaleList($data['type']);
        }
    }


    private function getLocalePage(Page $page)
    {
        $html = '';

        foreach ($this->locales as $_locale) {
            if ($page->getTranslation('published', $_locale)) {
                $pageLink = ($page->getFolder())
                    ? $page->getFolder()->getTranslation('slug', $_locale).'/'.$page->getTranslation('slug', $_locale)
                    : $page->getTranslation('slug', $_locale);
                $href = $this->router->generate('cms_page_show', array('pageLink' => $pageLink, '_locale' => $_locale));
                $src = $this->asset->getAssetUrl('assets/img/flags/'.$_locale.'.png');
                $html .= '<a href="'.$href.'"><img src="'.$src.'" /></a>';
            }
        }

        return $html;
    }


    private function getLocalePost(AbstractPost $post, $type)
    {
        $html = '';

        foreach ($this->locales as $_locale) {
            if ($post->getTranslation('published', $_locale)) {
                $href = $this->router->generate('cms_post_show', array('type' => $type, '_locale' => $_locale, 'slug' => $post->getTranslation('slug', $_locale)));
                $src = $this->asset->getAssetUrl('assets/img/flags/'.$_locale.'.png');
                $html .= '<a href="'.$href.'"><img src="'.$src.'" /></a>';
            }
        }

        return $html;
    }


    private function getLocaleTaxo(AbstractTaxonomy $taxo, $type)
    {
        $html = '';

        foreach ($this->locales as $_locale) {
            if ($taxo->getTranslation('published', $_locale)) {
                $href = $this->router->generate('cms_taxo_show', array('type' => $type, '_locale' => $_locale, 'slug' => $taxo->getTranslation('slug', $_locale)));
                $src = $this->asset->getAssetUrl('assets/img/flags/'.$_locale.'.png');
                $html .= '<a href="'.$href.'"><img src="'.$src.'" /></a>';
            }
        }

        return $html;
    }

    private function getLocaleList($type)
    {
        $html = '';

        foreach ($this->locales as $_locale) {
            $href = $this->router->generate('cms_list_show', array('type' => $type, '_locale' => $_locale));
            $src = $this->asset->getAssetUrl('assets/img/flags/'.$_locale.'.png');
            $html .= '<a href="'.$href.'"><img src="'.$src.'" /></a>';

        }

        return $html;
    }


}