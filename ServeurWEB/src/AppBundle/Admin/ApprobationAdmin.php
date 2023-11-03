<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM\EntityRepository;

class ApprobationAdmin extends AbstractAdmin
{
	/**
	 * @param DatagridMapper $datagridMapper
	 */
	
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		

		$em = $this->modelManager->getEntityManager('UserBundle\Entity\User');
		$ApprobateurUser = $em->createQueryBuilder('c')
		->select('c')
		->from('UserBundle:User', 'c')
		->Join('c.groups', 'g')->addSelect('g')
		->where('g.name = :approbateur')
		->setParameter('approbateur', 'Approbateur');
		
		$datagridMapper
		->add('approbateur','sonata_type_model', array('label' => 'Affectation','query' => $ApprobateurUser, 'btn_add' => false, 'required' => false))	;
	}

	/**
	 * @param ListMapper $listMapper
	 */
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->add('id')
		->add('approbateur')
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
		$em = $this->modelManager->getEntityManager('UserBundle\Entity\User');
		$ApprobateurUser = $em->createQueryBuilder('c')
		->select('c')
		->from('UserBundle:User', 'c')
		->Join('c.groups', 'g')->addSelect('g')
		->where('g.name = :approbateur')
		->setParameter('approbateur', 'Approbateur');
		
		$formMapper
		->add('approbateur','sonata_type_model', array('label' => 'Affectation','query' => $ApprobateurUser, 'btn_add' => false, 'required' => false))	;
	}

	/**
	 * @param ShowMapper $showMapper
	 */
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
		->add('approbateur')

		;
	}
}
