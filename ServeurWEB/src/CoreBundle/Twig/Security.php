<?php


namespace CoreBundle\Twig;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class Security extends \Twig_Extension
{

    protected $tokenStorage;
    protected $authorisationChecker;

    public function __construct(TokenStorage $tokenStorage, AuthorizationChecker $authorisationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorisationChecker = $authorisationChecker;
    }

    public function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    public function allowAccess($groups = array())
    {

        if (!is_object($this->getUser())) { // not connected
            return false;
        }

        if ($this->authorisationChecker->isGranted('ROLE_ADMIN')) {
            return true;
        }


        foreach ($groups as $group) {
            if (in_array($group, $this->getUser()->getGroups()->toArray())) {
                return true;
            }
        }

        return false;

    }

    public function hasRoles($roles = array())
    {
        foreach ($roles as $role) {
            if ($this->authorisationChecker->isGranted($role)) {
                return true;
            }
        }

        return false;
    }

    public function granted($bundle, $entity, $action)
    {

        return (
            $this->authorisationChecker->isGranted('ROLE_'.strtoupper($bundle).'_ADMIN_'.strtoupper($entity).'_'.strtoupper($action)) ||
            $this->authorisationChecker->isGranted('ROLE_'.strtoupper($bundle).'_ADMIN_'.strtoupper($entity).'_ALL') ||
            $this->authorisationChecker->isGranted('ROLE_SUPER_ADMIN')
        );

    }

    public function check($string) {
        return ($this->authorisationChecker->isGranted($string) || $this->authorisationChecker->isGranted('ROLE_SUPER_ADMIN'));
    }

    public function getFunctions()
    {
        return array(
            'granted' => new \Twig_Function_Method($this, 'granted'),
        );
    }

    public function getName()
    {
        return 'Security';
    }

}