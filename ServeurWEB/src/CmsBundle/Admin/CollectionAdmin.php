<?php

namespace CmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CollectionAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name', null, ['label' => 'Nom'])
            ->add('uniqueSlug')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name', null, ['label' => 'Nom'])
            ->add('uniqueSlug')
            ->add('items')
            ->add('vue', null, ['label' => 'Vue'])
            ->add('cache', null, ['label' => 'Mise en cache ?', 'editable' => true])
            ->add('cacheTime', null, ['label' => 'Durée du cache'])
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'slide' => array('template' => 'CmsBundle:Collection:collection_action_item.html.twig'),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, ['label' => 'Nom'])
            ->add('vue', null, ['label' => 'Vue'])
            ->add('cache', null, ['label' => 'Mise en cache ?'])
            ->add('cacheTime', null, ['label' => 'Durée du cache'])
            ->add('content', null, ['label' => 'Twig'])
        ;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'CmsBundle:Collection:collection_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }


}
