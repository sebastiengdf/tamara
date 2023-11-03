<?php

namespace CoreBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class VariableAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, ['label' => 'Nom'])
            ->add('value', null, ['label' => 'Valeur'])
            ->add('content', null, ['label' => 'Description'])
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

        $disabled = ($this->getSubject()->getId()) ? true : false;

        $formMapper
            ->with('Général', ['class' => 'col-md-6'])
                ->add('name', null, ['label' => 'Nom', 'disabled' => $disabled])
                ->add('value', null, ['label' => 'Valeur'])
            ->end()
            ->with('Description', ['class' => 'col-md-6'])
                ->add('content', CKEditorType::class, array('required' => false, 'config_name' => 'simple', 'label' => false))
            ->end()
        ;
    }
}
