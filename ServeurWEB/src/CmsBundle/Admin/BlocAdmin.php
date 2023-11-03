<?php

namespace CmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BlocAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('uniqueSlug')
            ->add('content')
            ->add('published')
            ->add('cache')
            ->add('etag')
            ->add('cacheTime')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, ['label' => 'Nom'])
            ->add('uniqueSlug', null, ['label' => 'Slug'])
            ->add('published', null, ['label' => 'Publié ?', 'editable' => true])
            ->add('cache', null, ['label' => 'En cache ?', 'editable' => true])
            ->add('cacheTime', null, ['label' => 'Temps de cache'])
            ->add('_action', null, array(
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
            ->add('name')
            ->add('uniqueSlug')
            ->add('content')
            ->add('published')
            ->add('cache')
            ->add('cacheTime')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('uniqueSlug')
            ->add('content')
            ->add('published')
            ->add('cache')
            ->add('etag')
            ->add('cacheTime')
        ;
    }

    //------------------------------------------------------------------------------------------------------
    //  getTemplate
    //------------------------------------------------------------------------------------------------------

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'CmsBundle:Bloc:bloc_edit.html.twig';
                break;
            case 'list':
                return 'CmsBundle:Bloc:bloc_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }


}
