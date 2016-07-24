<?php

namespace AppBundle\Controller\Auth;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ForgottenController extends Controller
{

    /**
     * {@inheritdoc}
     * @Route("/auth/forgotten", name="auth_forgotten")
     */
    public function forgottenAction(Request $request)
    {

    }
}