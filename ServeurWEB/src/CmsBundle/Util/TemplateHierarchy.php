<?php

namespace CmsBundle\Util;

use CmsBundle\Twig\GetConfigCms;

class TemplateHierarchy
{
    const FOLDER_THEMES = "themes";

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var string
     */
    private $basePathShorcut;

    /**
     * TemplateHierarchy constructor.
     */
    public function __construct(GetConfigCms $getConfigCms)
    {
        $theme = $getConfigCms->getConfigCms()->getTheme();
        $this->basePath = "/Resources/views/".self::FOLDER_THEMES."/$theme/";
        $this->basePathShorcut = ":".self::FOLDER_THEMES."/$theme";
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return string
     */
    public function getBasePathShorcut()
    {
        return $this->basePathShorcut;
    }

    public function getTemplatePost($type, $slug, $rootDir)
    {
        $template = $this->basePathShorcut. ':single.html.twig';

        if (file_exists($rootDir. $this->basePath . 'single-'.$type.'.html.twig')) {
            $template = $this->basePathShorcut . ':single-'.$type.'.html.twig';
        }

        if (file_exists($rootDir. $this->basePath . 'single-'.$type.'-'.$slug.'.html.twig')) {
            $template = $this->basePathShorcut . ':single-'.$type.'-'.$slug.'.html.twig';
        }

        return $template;
    }
    public function getTemplatePage($slug, $rootDir)
    {
        $template = $this->basePathShorcut . ':page.html.twig';

        if (file_exists($rootDir. $this->basePath . 'page-'.$slug.'.html.twig')) {
            $template = $this->basePathShorcut . ':page-'.$slug.'.html.twig';
        }

        return $template;
    }

    public function getTemplateTaxo($type, $slug = null, $rootDir)
    {
        $template = $this->basePathShorcut . ':archive.html.twig';

        if (file_exists($rootDir. $this->basePath . 'archive-'.$type.'.html.twig')) {
            $template = $this->basePathShorcut . ':archive-'.$type.'.html.twig';
        }


        if (file_exists($rootDir. $this->basePath . 'archive-'.$type.'-'.$slug.'.html.twig')) {
            $template = $this->basePathShorcut . ':archive-'.$type.'-'.$slug.'.html.twig';
        }

        return $template;
    }


}