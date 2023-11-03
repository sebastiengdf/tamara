<?php

namespace UserBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use FOS\UserBundle\Model\User;


class UserAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, ['label' => 'ID'])
            ->add('firstname', null, ['label' => 'Prénom'])
            ->add('lastname', null, ['label' => 'Nom'])
            ->add('username', null, ['label' => 'Login'])
            ->add('email', null, ['label' => 'Email'])
            ->add('enabled', null, ['label' => 'Actif'])
            ->add('groups', null, ['label' => 'Groupes'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['label' => 'ID'])
            ->add('firstname', null, ['label' => 'Prénom', 'editable' => true])
            ->add('lastname', null, ['label' => 'Nom', 'editable' => true])
            ->add('username', null, ['label' => 'Login', 'editable' => true])
            ->add('email', null, ['label' => 'Email', 'editable' => true])
            ->add('enabled', null, ['label' => 'Actif', 'editable' => true])
            ->add('groups', null, array('label' => 'Groupes', 'template' => 'UserBundle:User:user_grid_groups.html.twig', 'attr' => array('class' => 'AjouteLigne')))
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
    	$formMapper

            ->add('username', TextType::class, ['label' => 'Login'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('plainPassword', PasswordType::class,array('required' => (!$this->getSubject() || is_null($this->getSubject()->getId())), 'label' => 'Password'))
            ->add('enabled', CheckboxType::class, ['label' => 'Actif', 'required' => false])
            ->add('firstname', TextType::class, ['label' => 'Prénom', 'required' => false])
            ->add('lastname', TextType::class, ['label' => 'Nom', 'required' => false])
            ->add('avatar', 'sonata_type_admin', ['required' => false])
            ->add('content', CKEditorType::class, array('required' => false, 'config_name' => 'simple', 'label' => false))
            ->add('groups', 'sonata_type_model', ['class' => 'UserBundle:Group', 'expanded' => true, 'multiple' => true, 'label' => false, 'required' => false])
            ->add(
                'roles',
                ChoiceType::class,
                array(
                    'choices'  => $this->getConfigurationPool()->getContainer()->get('core.service.role')->getExistingRoles(),
                    'label'    => false,
                    'expanded' => true,
                    'multiple' => true,
                    'mapped'   => true,
                    'required' => false,
                )
            )
        ;
    }

    //------------------------------------------------------------------------------------------------------
    //  getTemplate
    //------------------------------------------------------------------------------------------------------

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'AppBundle:User:user_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    //------------------------------------------------------------------------------------------------------
    //  prePersist
    //------------------------------------------------------------------------------------------------------

    public function prePersist($object)
    {
    	if (isset($this->userType)) {
            $object->setType($this->userType);
        }
    }


    

    //------------------------------------------------------------------------------------------------------
    //  prePersist
    //------------------------------------------------------------------------------------------------------
    
    public function preUpdate($object)
    {
    	parent::preUpdate($object);
    	$this->updateUser($object);
    }
    
    
    public function updateUser(User $user){
     $om= $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager');
     $om->updateUser($user,false);
    	
    	
    }
    
    //------------------------------------------------------------------------------------------------------
    //  createQuery
    //------------------------------------------------------------------------------------------------------

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if ($context == 'list' and isset($this->userType)) {
            $query->andWhere('o.type = :type')->setParameter('type', $this->userType);
        }

        return $query;
    }


}
