<?php

namespace AppBundle\Controller\Auth;

use AppBundle\Controller\CsrfTrait;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User\User;
use AppBundle\Form\Auth\Registration as RegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;


class RegistrationController extends Controller
{
    use CsrfTrait;

    /**
     * {@inheritdoc}
     * @Route("/auth/register", name="auth_register")
     */
    public function registerAction(Request $request)
    {
        
        $user = new User();
        $user->setEnabled(true);
        
        $formBuilder = new RegistrationForm();
        $form = $formBuilder->build($this->createFormBuilder($user));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UserPasswordEncoder $encoder */
            $encoder = $this->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword($user, ''));

            /** @var EntityManager $em */
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();

            return $this->render('AppBundle:Registration:success.html.twig');
        }


        return $this->render('AppBundle:Registration:register.html.twig', ['form' => $form->createView()]);
    }
}