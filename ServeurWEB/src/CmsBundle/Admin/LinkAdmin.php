<?php

namespace CmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LinkAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('page')
            ->add('published')
            ->add('rootLink')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', 'text', array('editable' => true))
            ->add('linkType')
            ->add('page')
            ->add('published', null, array('editable' => true))
            ->add('rootLink')
            ->add('parent')
            ->add('language', 'string', array('template' => 'CmsCoreBundle:Admin:selected_lang.html.twig', 'label' => 'Langue'))
            ->add('_action', 'actions', array(
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
        $auth = $this->getConfigurationPool()->getContainer()->get('core.security')->check('ROLE_CMS_NAV_ADMIN_LINK_MASTER');

        $formMapper
            ->tab('Général')
            ->with('Identification', array('class' => 'col-md-6'))
            //identification
            ->add('name', 'text', array('label' => 'Nom', 'help' => 'trans', 'attr' => array('autofocus' => 'autofocus')))
            ->add('slug', 'text', array('label' => 'Slug', 'required' => false, 'help' => 'trans'))
            ->end()
            ->with('Status', array('class' => 'col-md-6'))
            // status
            ->add('published', 'checkbox', array('label' => 'Publication', 'required' => false, 'label_attr' => array('class' => 'help-trans')))
            ->add('external', null, array('label' => 'Lien externe ?'))
            ->end()
            ->end()
            ->tab('Lien')
            ->with('Type de lien')
            ->add('linkType', 'choice', array(
                'attr'=> array('data-sonata-select2'=>'false'),
                'choices' => array(
                    '----' => '',
                    'Page' => 'PAGE',
                    'Lien libre' => 'LINK',
                    'Routing' => 'ROUTE',
//                    'ARTICLE' => 'Article',
//                    'CATEGORY' => 'Catégorie',
                )
            ))
            ->end()
            ->with('Page', array('class' => 'link-page col-md-12'))
            ->add('page')
            ->end()
//            ->with('Article', array('class' => 'link-article col-md-12'))
//            ->add('article')
//            ->end()
//            ->with('Catégorie', array('class' => 'link-category col-md-12'))
//            ->add('category')
//            ->end()
            ->with('Url', array('class' => 'link-url col-md-12'))
            ->add('link', 'text', array('label' => 'URL', 'required' => false, 'help' => 'trans'))
            ->add('linkParams', 'sonata_type_collection', array('required' => false, 'by_reference' => false, 'label' => 'Parametres hors route', 'type_options' => array('delete' => true)), array('edit' => 'inline', 'inline' => 'table',))
            ->end()
            ->with('Nom de route', array('class' => 'link-route col-md-12'))
            ->add('routeName', 'text', array('label' => 'Nom de la route', 'required' => false))
            ->add('routeArgs', 'sonata_type_collection', array('required' => false, 'by_reference' => false, 'label' => 'Arguments pour la route', 'type_options' => array('delete' => true)), array('edit' => 'inline', 'inline' => 'table',))
            ->end()
            ->end();
        if($auth) {
            $formMapper->tab('Intégration spécifique')
                ->add('childrenAttributes', 'sonata_type_collection', array('required' => false, 'by_reference' => false, 'label' => 'Integration du ul', 'type_options' => array('delete' => true)), array('edit' => 'inline', 'inline' => 'table',))
                ->add('attributes', 'sonata_type_collection', array('required' => false, 'by_reference' => false, 'label' => 'Integration du li', 'type_options' => array('delete' => true)), array('edit' => 'inline', 'inline' => 'table',))
                ->add('linkAttributes', 'sonata_type_collection', array('required' => false, 'by_reference' => false, 'label' => 'Integration du a', 'type_options' => array('delete' => true)), array('edit' => 'inline', 'inline' => 'table',))
                ->end()->end()
            ;
        }

    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('external')
            ->add('link')
            ->add('liHtml')
            ->add('aHtml')
            ->add('created')
            ->add('updated')
            ->add('position')
            ->add('published')
            ->add('name')
            ->add('slug')
        ;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'CmsBundle:Link:link_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

}
