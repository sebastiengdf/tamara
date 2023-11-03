<?php

namespace CmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MenuAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('uniqueSlug')
            ->add('menuType')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('uniqueSlug')
            ->add('menuType')
            ->add('style')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Nom', array('class' => 'col-md-4'))
            ->add('name', null, array('label' => 'Nom', 'attr' => array('autofocus' => 'autofocus')))
            ->end()
            ->with('Slug', array('class' => 'col-md-4'))
            ->add('uniqueSlug')
            ->end()
            ->with('Intégration', array('class' => 'col-md-4'))
            ->add('menuType', 'entity', array('class' => 'CmsBundle\Entity\MenuType', 'required' => true, 'label' => 'Type Bootstrap'))
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('uniqueSlug')
        ;
    }

    public function getTemplate($name) {
        switch ($name) {
            case 'edit':
                return 'CmsBundle:Menu:menu_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}
