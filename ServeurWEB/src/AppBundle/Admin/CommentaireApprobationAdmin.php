<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CommentaireApprobationAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('content')
            ->add('created')
            ->add('updated')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('content')
            ->add('created')
            ->add('updated')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
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
        	->add('user', null, array('label' => 'Utilisateur'))
        	->add('created', 'sonata_type_date_picker', array('label' => 'Date', 'required' => true, 'format' => 'dd/MM/yyyy'))
        	->add('content', CKEditorType::class, array('required' => false, 'config_name' => 'simple', 'label' => 'Commentaire'))	
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('content')
        ;
    }
    
    public function getNewInstance()
    {
        $container = $this->getConfigurationPool()->getContainer();
        $instance = parent::getNewInstance();
        $instance->setUser($container->get('core.security')->getUser());
        return $instance;
    }

}
