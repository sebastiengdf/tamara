<?php


namespace UserBundle\DataFixtures\ORM;

use CoreBundle\Entity\Config;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\Group;

class LoadUser implements FixtureInterface, ContainerAwareInterface
{

    protected $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        //------------------------------------------------------------------------------------------------------
        //  group
        //------------------------------------------------------------------------------------------------------

        $types = array('EDIT', 'LIST', 'CREATE');

        $groups = [
            1 => array(
                'name'       => 'Super Administrateur',
                'color'      => 'bg-red-active color-palette',
                'roles'      => array(),
                'extraRoles' => array(
                    'ROLE_SUPER_ADMIN',
                )
            ),
        ];

        $groupO = array();

        foreach ($groups as $key => $data) {
            $roles = array();

            if (isset($data['roles'])) {
                foreach ($data['roles'] as $role) {
                    foreach ($types as $type) {
                        $roles[] = $role.'_'.$type;
                    }
                }
            }

            if (isset($data['extraRoles'])) {
                foreach ($data['extraRoles'] as $role) {
                    $roles[] = $role;
                }
            }

            $group = new Group($data['name'], $roles);
            $group->setColor($data['color']);
            $groupO[$key] = $group;
            $manager->persist($group);
            $manager->flush();
        }

        //------------------------------------------------------------------------------------------------------
        //  user
        //------------------------------------------------------------------------------------------------------
/*
        $userManager = $this->container->get('fos_user.user_manager');

        $users = [
            1 => [
                'username'      => 'admin',
                'email'         => 'admin@admin.fr',
                'plainPassword' => 'admin',
                'groups'        => [1]
            ]
        ];

        $userO = array();

        foreach ($users as $userNumber => $datas) {
            $user = $userManager->createUser();
            foreach ($datas as $field => $data) {
                if($field == 'groups') {
                    foreach ($data as $group) {
                        $user->addGroup($groupO[$group]);
                    }
                } else {
                    $method = 'set'.ucfirst($field);
                    $user->$method($data);
                }
            }
            $user->setEnabled(true);
            $userManager->updateUser($user, true);
            $userO[$userNumber] = $user;
        }  */      
    }
}