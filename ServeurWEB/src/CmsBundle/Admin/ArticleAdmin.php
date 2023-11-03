<?php

namespace CmsBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleAdmin extends AbstractPostAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('category', null, ['label' => 'Catégorie']);
        $datagridMapper->add('tags', null, ['label' => 'Tags']);
        parent::configureDatagridFilters($datagridMapper);
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('category', null, ['label' => 'Catégorie']);
        $listMapper->add('tags', null, ['label' => 'Tags']);
        parent::configureListFields($listMapper);
    }


    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('tags', 'sonata_type_model', array('required' => false, 'label' => 'Mots clés', 'multiple' => true));
    }

    //------------------------------------------------------------------------------------------------------
    //  getTemplate
    //------------------------------------------------------------------------------------------------------

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'CmsBundle:Article:article_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }


}
