<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User\User;
use AppBundle\Entity\Role\RoleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
//        /** @var User $user */
//        $user = $this->getUser();
//
//        /** @var RoleRepository $repo */
//        $repo = $this->get('app.repository.role');
//
//        foreach ($repo->findAll() as $role) {
//            $user->addRole($role);
//        }
//
//        $em = $this->get('doctrine.orm.entity_manager');
//        $em->persist($user);
//        $em->flush();

        return $this->render('AppBundle:Home:index.html.twig');
    }
}
