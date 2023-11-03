<?php

namespace CmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PageAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'Nom'])
            ->add('folder', null, ['label' => 'Dossier'])
            ->add('layout', null, ['label' => 'Layout'])
            ->add('count', null, ['label' => 'Visite'])
            ->add('published', null, ['label' => 'Publié ?'])
            ->add('created', null, ['label' => 'Date de création'])
            ->add('cache', null, ['label' => 'Cache ?'])
            ->add('privateAccess', null, ['label' => 'Accès restreint ?'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('identification', 'string', ['label' => 'Identification', 'template' => 'CmsBundle:Page:page_grid_identification.html.twig'])
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
            ->add('name', null, ['help' => 'trans', 'label' => 'Nom'])
            ->add('content', null, ['help' => 'trans', 'label' => 'Contenu'])
            ->add('published', CheckboxType::class, ['label' => 'Publication', 'required' => false, 'label_attr' => ['class' => 'help-trans']])
            ->add('publishedStart', DateTimePickerType::class, ['required' => false, 'label' => 'Début de publication', 'help' => 'trans'])
            ->add('publishedEnd', DateTimePickerType::class, ['required' => false, 'label' => 'Fin de publication', 'help' => 'trans'])
            ->add('created', DateTimePickerType::class, ['required' => false, 'label' => 'Date de création', 'disabled' => true])
            ->add('updated', DateTimePickerType::class, ['required' => false, 'label' => 'Date de modification', 'disabled' => true])
            ->add('folder', ModelListType::class, ['label' => 'Dossier', 'required' => false])
            ->add('layout', ModelListType::class, ['label' => 'Template', 'required' => false])
            ->add('privateAccess', null, array('label' => 'Accès privé'))
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
            ->add('stylesheets')
            ->add('javascripts')
        ;
    }


    //------------------------------------------------------------------------------------------------------
    //  getTemplate
    //------------------------------------------------------------------------------------------------------

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'CmsBundle:Page:page_edit.html.twig';
                break;
            case 'list':
                return 'CmsBundle:Page:page_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}
