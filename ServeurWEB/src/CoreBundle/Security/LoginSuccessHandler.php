<?php

namespace CoreBundle\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     *
     * @return Response never null
     */

    protected $router;
    protected $request;

    public function __construct(Router $router, RequestStack $request)
    {
        $this->router = $router;
        $this->request = $request;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {

        $route = ($token->getUser()->hasRole('ROLE_ADMIN') or $token->getUser()->hasRole('ROLE_SUPER_ADMIN')) ? 'sonata_admin_dashboard' : 'homepage';

        $response = new RedirectResponse($this->router->generate($route));

        $session = $this->request->getCurrentRequest()->getSession();

        if ($session->get('redirectAfterLogin')) {
            $redirectAfterLogin = $session->get('redirectAfterLogin');

            if ($redirectAfterLogin['type'] == 'page' and $redirectAfterLogin['pageLink']) { // page
                $response = new RedirectResponse(
                    $this->router->generate(
                        'cms_page_show',
                        array(
                            '_locale' => $redirectAfterLogin['_locale'],
                            'pageLink' => $redirectAfterLogin['pageLink']
                        )
                    )
                );
            }

            if ($redirectAfterLogin['type'] == 'taxo') { // page
                $response = new RedirectResponse(
                    $this->router->generate(
                        'cms_taxo_show',
                        array(
                            '_locale' => $redirectAfterLogin['_locale'],
                            'type' => $redirectAfterLogin['typeTaxo'],
                            'slug' => $redirectAfterLogin['slug']
                        )
                    )
                );
            }

            $session->remove('redirectAfterLogin');
        }

        return $response;
    }
}