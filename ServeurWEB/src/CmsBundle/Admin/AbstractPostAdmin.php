<?php

namespace CmsBundle\Admin;

use CmsBundle\Entity\AbstractPost;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

abstract class AbstractPostAdmin extends AbstractAdmin
{

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'position',
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'Nom'])
            ->add('publishedStart', null, ['label' => 'Date'])
            ->add('count', null, ['label' => 'Visite'])
            ->add('user', null, ['label' => 'Editeur'])
            ->add('published', null, ['label' => 'Publication'])
            ->add('top', null, ['label' => 'Top'])
            ->add('privateAccess', null, array('label' => 'Accès privé'))
            ->add('cache', null, ['label' => 'Cache'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('cover', null, array('template' => 'CmsBundle:Cms:list_image.html.twig', 'label' => 'Couverture'))
            ->addIdentifier('name', null, ['label' => 'Nom'])
            ->add('publishedStart', null, ['label' => 'Date'])
            ->add('count', null, ['label' => 'Visite'])
            ->add('user', null, ['label' => 'Editeur'])
            ->add('published', null, ['label' => 'Publication', 'editable' => true])
            ->add('top', null, ['label' => 'Top', 'editable' => true])
            ->add('privateAccess', null, array('label' => 'Accès privé', 'editable' => true))
            ->add('cache', null, ['label' => 'Cache', 'editable' => true])
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                    'show' => ['template' => 'CmsBundle:Post:post_action_show.html.twig']
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
            ->add('name', null, ['help' => 'trans', 'label' => 'Nom'])
            ->add('excerpt', null, ['help' => 'trans', 'label' => 'Extrait'])
            ->add('content', CKEditorType::class, ['help' => 'trans', 'label' => 'Contenu'])
            ->add('privateAccess', null, array('label' => 'Accès privé ?'))
            ->add('allowedGroups', 'sonata_type_model', array('required' => false, 'label' => 'Groupes autorisés', 'multiple' => true))
            ->add('cache', null, ['label' => 'Mise en cache ?'])
            ->add('cacheTime', null, ['label' => 'Durée du cache'])
            ->add('title', null, ['help' => 'trans'])
            ->add('H1', null, ['help' => 'trans'])
            ->add('slug', null, ['help' => 'trans'])
            ->add('uniqueSlug', null, ['help' => 'trans', 'disabled' => true])
            ->add('metaDescription', null, ['help' => 'trans'])
            ->add('metaKeyword', null, ['help' => 'trans'])
            ->add('otherMeta', null, ['help' => 'trans'])
            ->add('noIndex', null, ['label' => 'Ne pas indexer', 'label_attr' => ['class' => 'help-trans']])
            ->add('layout', ModelListType::class, ['label' => 'Template', 'required' => false])
            ->add('published', CheckboxType::class, ['label' => 'Publication ?', 'required' => false, 'label_attr' => ['class' => 'help-trans']])
            ->add('publishedStart', DateTimePickerType::class, ['required' => false, 'label' => 'Début de publication', 'help' => 'trans'])
            ->add('publishedEnd', DateTimePickerType::class, ['required' => false, 'label' => 'Fin de publication', 'help' => 'trans'])
            ->add('created', DateTimePickerType::class, ['required' => false, 'label' => 'Date de création', 'disabled' => true])
            ->add('updated', DateTimePickerType::class, ['required' => false, 'label' => 'Date de modification', 'disabled' => true])
            ->add('stylesheets')
            ->add('javascripts')
            ->add('top', null, ['label' => 'Article à la une ?'])
            ->add('enableComment', null, ['label' => 'Activer les commentaires ?'])
            ->add('author', null, ['label' => 'Auteur'])
            ->add(
                'pictures',
                'sonata_type_collection',
                array('required' => false, 'by_reference' => false, 'label' => false, 'type_options' => array('delete' => true)),
                array('edit' => 'inline', 'inline' => 'table', 'sortable' => 'position',)
            )
            ->add(
                'videos',
                'sonata_type_collection',
                array('required' => false, 'by_reference' => false, 'label' => false, 'type_options' => array('delete' => true)),
                array('edit' => 'inline', 'inline' => 'table', 'sortable' => 'position',)
            )
            ->add(
                'files',
                'sonata_type_collection',
                array('required' => false, 'by_reference' => false, 'label' => false, 'type_options' => array('delete' => true)),
                array('edit' => 'inline', 'inline' => 'table', 'sortable' => 'position',)
            )
            ->add(
                'fields',
                'sonata_type_collection',
                array('required' => false, 'by_reference' => false, 'label' => false, 'type_options' => array('delete' => true)),
                array('edit' => 'inline', 'inline' => 'table', 'sortable' => 'position',)
            )
            ->add(
                'cover',
                'sonata_type_model_list',
                array('required' => false, 'label' => false),
                array('link_parameters' => array('context' => 'picture', 'provider' => 'sonata.media.provider.image'))
            )
        ;
    }

    //------------------------------------------------------------------------------------------------------
    //  getNewInstance
    //------------------------------------------------------------------------------------------------------
    public function getNewInstance()
    {
        $container = $this->getConfigurationPool()->getContainer();
        /** @var AbstractPost $instance */
        $instance = parent::getNewInstance();
        $instance->setUser($container->get('core.security')->getUser());
        $instance->setAuthor($container->get('core.security')->getUser()->__toString());

        return $instance;
    }


    //------------------------------------------------------------------------------------------------------
    //  getTemplate
    //------------------------------------------------------------------------------------------------------

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'CmsBundle:Post:post_edit.html.twig';
                break;
            case 'list':
                return 'CmsBundle:Post:post_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

}
