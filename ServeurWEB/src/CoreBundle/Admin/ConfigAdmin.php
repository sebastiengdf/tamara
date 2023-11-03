<?php

namespace CoreBundle\Admin;

use CoreBundle\Entity\Traits\Containerable;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ConfigAdmin extends AbstractAdmin
{

    use Containerable;

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'AppBundle:Config:config_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }


    //------------------------------------------------------------------------------------------------------
    //  getTemplate
    //------------------------------------------------------------------------------------------------------

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, ['label' => 'Nom']);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

}
