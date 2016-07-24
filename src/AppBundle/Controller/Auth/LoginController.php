<?php

namespace AppBundle\Controller\Auth;

use AppBundle\Controller\CsrfTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class LoginController extends Controller
{
    use CsrfTrait;

    /**
     * {@inheritdoc}
     * @Route("/auth/login", name="auth_login")
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null;
        }

        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);


        return $this->render('AppBundle:Security:login.html.twig',
            [
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $this->getCsrfToken(),
            ]
        );
    }

    /**
     * @Route("/auth/check", name="auth_check")
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/auth/logout", name="auth_logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }


    public function registerAction()
    {
        
    }
}