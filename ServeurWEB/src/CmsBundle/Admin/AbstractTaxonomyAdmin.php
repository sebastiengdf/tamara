<?php

namespace CmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

abstract class AbstractTaxonomyAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'Nom'])
            ->add('created', null, ['label' => 'Date'])
            ->add('count', null, ['label' => 'Visite'])
            ->add('publishedStart', null, ['label' => 'Date'])
            ->add('published', null, ['label' => 'Publication'])
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
            ->add('name', null, ['label' => 'Nom'])
            ->add('created', null, ['label' => 'Date'])
            ->add('count', null, ['label' => 'Visite'])
            ->add('publishedStart', null, ['label' => 'Date'])
            ->add('published', null, ['label' => 'Publication', 'editable' => true])
            ->add('privateAccess', null, array('label' => 'Accès privé', 'editable' => true))
            ->add('cache', null, ['label' => 'Cache', 'editable' => true])
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                    'show' => ['template' => 'CmsBundle:Taxonomy:taxonomy_action_show.html.twig']
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
            ->add('content', null, ['help' => 'trans', 'label' => 'Contenu'])
            ->add('privateAccess', null, array('label' => 'Accès privé ?'))
            ->add('allowedGroups', 'sonata_type_model', array('required' => false, 'label' => 'Groupes autorisés', 'multiple' => true))
            ->add('cache', null, ['label' => 'Mise en cache ?'])
            ->add('cacheTime', null, ['label' => 'Durée du cache'])
            ->add('title', null, ['help' => 'trans'])
            ->add('H1', null, ['help' => 'trans'])
            ->add('layout', ModelListType::class, ['label' => 'Template', 'required' => false])
            ->add('slug', null, ['help' => 'trans'])
            ->add('uniqueSlug', null, ['help' => 'trans', 'disabled' => true])
            ->add('metaDescription', null, ['help' => 'trans'])
            ->add('metaKeyword', null, ['help' => 'trans'])
            ->add('otherMeta', null, ['help' => 'trans'])
            ->add('noIndex', null, ['label' => 'Ne pas indexer', 'label_attr' => ['class' => 'help-trans']])
            ->add('published', CheckboxType::class, ['label' => 'Publication ?', 'required' => false, 'label_attr' => ['class' => 'help-trans']])
            ->add('publishedStart', DateTimePickerType::class, ['required' => false, 'label' => 'Début de publication', 'help' => 'trans'])
            ->add('publishedEnd', DateTimePickerType::class, ['required' => false, 'label' => 'Fin de publication', 'help' => 'trans'])
            ->add('created', DateTimePickerType::class, ['required' => false, 'label' => 'Date de création', 'disabled' => true])
            ->add('updated', DateTimePickerType::class, ['required' => false, 'label' => 'Date de modification', 'disabled' => true])
            ->add('stylesheets')
            ->add('javascripts')
            ->add(
                'cover',
                'sonata_type_model_list',
                array('required' => false, 'label' => false),
                array('link_parameters' => array('context' => 'picture', 'provider' => 'sonata.media.provider.image'))
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
                return 'CmsBundle:Taxonomy:taxonomy_edit.html.twig';
                break;
            case 'list':
                return 'CmsBundle:Taxonomy:taxonomy_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }


}
