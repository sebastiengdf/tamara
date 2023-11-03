<?php

namespace CmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;

class ListSeoAdmin extends AbstractAdmin
{
	public function getTemplate( $name ) {
		switch ( $name ) {
			case 'edit':
				return 'CmsBundle:ListSeo:list_seo_edit.html.twig';
				break;
			default:
				return parent::getTemplate( $name );
				break;
		}
	}

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('slug')
            ->add('excerpt')
            ->add('content')
            ->add('title')
            ->add('H1')
            ->add('metaDescription')
            ->add('metaKeyword')
            ->add('otherMeta')
            ->add('noIndex')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('slug')
            ->add('count')
            ->add('cache', null, ['label' => 'Cache', 'editable' => true])
            ->add('allowSingle', null, ['label' => 'Single', 'editable' => true])
            ->add('allowSingleAjax', null, ['label' => 'Single Ajax', 'editable' => true])
            ->add('allowList', null, ['label' => 'Liste', 'editable' => true])
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                    'show' => ['template' => 'CmsBundle:ListSeo:list_seo_action_show.html.twig'])
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
	        ->add( 'noIndex', null, [ 'help' => 'trans' ] )
	        ->add('title', null, ['help' => 'trans'])
	        ->add('H1', null, ['help' => 'trans'])
	        ->add('slug', null, ['help' => 'trans'])
            ->add('uniqueSlug', null, ['help' => 'trans', 'disabled' => true])
            ->add('metaDescription', null, ['help' => 'trans'])
	        ->add('metaKeyword', null, ['help' => 'trans'])
	        ->add('otherMeta', null, ['help' => 'trans'])
	        ->add('layout', ModelListType::class, ['label' => 'Template', 'required' => false])
	        ->add('stylesheets')
	        ->add('javascripts')
	        ->add('cache', null, ['label' => 'Mise en cache ?'])
	        ->add('cacheTime', null, ['label' => 'Durée du cache'])
	        ->add('allowSingle', null, ['label' => 'Voir les singles ?'])
	        ->add('allowSingleAjax', null, ['label' => 'Voir les singles ajax ?'])
	        ->add('allowList', null, ['label' => 'Voir la liste ?'])
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

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('slug')
            ->add('excerpt')
            ->add('content')
            ->add('title')
            ->add('H1')
            ->add('metaDescription')
            ->add('metaKeyword')
            ->add('otherMeta')
            ->add('noIndex')
        ;
    }
}
