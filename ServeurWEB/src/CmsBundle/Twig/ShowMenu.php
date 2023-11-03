<?php


namespace CmsBundle\Twig;


use CmsBundle\Provider\KnpProvider;
use Doctrine\ORM\EntityManager;
use Twig_Filter_Method;

class ShowMenu extends \Twig_Extension
{
    protected $manager;
    protected $twig;
    protected $provider;

    function __construct(EntityManager $manager, \Twig_Environment $twig, KnpProvider $provider)
    {
        $this->manager = $manager;
        $this->twig = $twig;
        $this->provider = $provider;
    }


    public function getName()
    {
        return 'showMenu';
    }

    public function getFunctions()
    {
        return array(
            'showMenu' => new \Twig_Function_Method($this, 'showMenu')
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            'parse_icons' => new Twig_Filter_Method(
                $this,
                'parseIconsFilter',
                array('pre_escape' => 'html', 'is_safe' => array('html'))
            )
        );
    }

    public function showMenu($slug) {
        return $this->twig->render('CmsBundle:Menu:knp.html.twig', array(
            'menu' => $this->manager->getRepository('CmsBundle:Menu')->getMenuAndType($slug)
        ));
    }


}