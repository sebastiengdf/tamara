<?php

namespace CoreBundle\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;

class Roles
{
    
    protected $container;

    /**
     * Roles constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getExistingRoles()
    {
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);

        foreach ($roles as $role) {
            $theRoles[$role] = $role;
        }
        return array_merge($theRoles, $this->getSonataRoles());
    }

    public function getSonataRoles() {
        $roles = ['LIST','VIEW','CREATE', 'EDIT', 'DELETE', 'EXPORT', 'OWNER', 'MASTER', 'ALL'];
        $services = [];
        foreach ($this->container->get('sonata.admin.pool')->getAdminServiceIds() as $item) {
            $key = 'ROLE_'.strtoupper(str_replace('.', '_', $item));
            foreach ($roles as $role) {
                $keyRole = $key.'_'.$role;
                $services[$keyRole] = $keyRole;
            }
        }
        return $services;
    }


}