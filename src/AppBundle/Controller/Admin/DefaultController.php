<?php

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Ticket\TicketManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    /**
     * {@inheritdoc}
     * @Route("/admin/", name="admin_homepage")
     */
    public function indexAction()
    {
        /** @var TicketManager $ticketManager */
        $ticketManager = $this->get('app.manager.ticket');
        $myTickets = $ticketManager->find(['assignee' => $this->getUser(), 'resolvedDate' => null]);
        $unassignedTickets = $ticketManager->find(['assignee' => null, 'resolvedDate' => null]);

        return $this->render('AppBundle:Admin:index.html.twig',
            [
                'userAssignedCount'     => count($myTickets),
                'unassignedCount'       => count($unassignedTickets),
                'userAssigned'          => $myTickets,
                'unassigned'            => $unassignedTickets
            ]
        );
    }

    /**
     * {@inheritdoc}
     * @Route("/admin", name="admin_homepage_")
     */
    public function adminAction()
    {
        return $this->redirectToRoute('admin_homepage');
    }
}