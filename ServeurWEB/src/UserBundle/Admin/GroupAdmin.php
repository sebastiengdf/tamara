<?php

namespace UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GroupAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'Nom du groupe'])
            ->add('roles', null, ['label' => 'Rôles'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, ['label' => 'Nom du groupe'])
            ->add('roles', null, ['label' => 'Rôles'])
            ->add(
                '_action',
                null,
                array(
                    'actions' => array(
                        'edit'   => array(),
                        'delete' => array(),
                    )
                )
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

//        var_dump($this->getConfigurationPool()->getContainer()->get('sonata.admin.pool')->getAdminServiceIds());
//        die();


        $formMapper
            ->add('name', null, ['label' => 'Nom du groupe'])
            ->add('color', null, ['label' => 'Couleur AdminLTE'])
            ->add(
                'roles',
                'choice',
                array(
                    'choices'  => $this->getConfigurationPool()->getContainer()->get('core.service.role')->getExistingRoles(),
                    'label'    => 'Roles',
                    'expanded' => true,
                    'multiple' => true,
                    'mapped'   => true,
                    'label'    => 'Rôle',
                )
            );
    }

    //------------------------------------------------------------------------------------------------------
    //  getTemplate
    //------------------------------------------------------------------------------------------------------

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'AppBundle:Group:group_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

}
