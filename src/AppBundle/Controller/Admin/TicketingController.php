<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\CsrfTrait;
use AppBundle\Entity\Ticket\TicketManager;
use AppBundle\Entity\TicketReply\TicketReplyManager;
use AppBundle\Entity\WorkflowTransition\WorkflowTransitionManager;
use AppBundle\Security\Voter\TicketVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TicketingController extends Controller
{

    use CsrfTrait;

    /**
     * {@inheritdoc}
     * @Route("/admin/tickets/view", name="admin_view_ticket")
     */
    public function viewAction(Request $request)
    {
        /** @var TicketManager $manager */
        $manager = $this->get('app.manager.ticket');

        $ticket = $manager->findByHumanId($request->get('id'));

<<<<<<< HEAD
        if (!$ticket || $ticket->getResourceId() !== $request->get('id')) {
=======
        if (!$ticket || $ticket->getHumanId() !== $request->get('id')) {
>>>>>>> e9e64361644b998e6348ba74050a34dd3565fb8b
            return $this->createNotFoundException();
        }

        $this->denyAccessUnlessGranted(TicketVoter::VIEW, $ticket);

        return $this->render(
            'AppBundle:Ticketing:view.html.twig',
            [
                'csrf_token' => $this->getCsrfToken(),
                'ticket' => $ticket,
            ]
        );
    }

    /**
     * {@inheritdoc}
     * @Route("/admin/tickets/addreply", name="admin_ticket_addreply")
     */
    public function addReplyAction(Request $request)
    {
        /** @var TicketManager $ticketManager */
        $ticketManager = $this->get('app.manager.ticket');
        /** @var TicketReplyManager $replyManager */
        $replyManager  = $this->get('app.manager.ticket_reply');

        $ticket = $ticketManager->findByHumanId($request->get('id'));

        if (!$ticket) {
            return $this->createNotFoundException();
        }

        $this->denyAccessUnlessGranted(TicketVoter::REPLY, $ticket);

        $reply = $replyManager->createReply($ticket, $this->getUser(), $request->get('_message'));
        $replyManager->addReply($reply);

<<<<<<< HEAD
        return $this->redirect($this->generateUrl('view_ticket', ['id' => $ticket->getResourceId()]));
=======
        return $this->redirect($this->generateUrl('view_ticket', ['id' => $ticket->getHumanId()]));
>>>>>>> e9e64361644b998e6348ba74050a34dd3565fb8b
    }

    /**
     * {@inheritdoc}
     * @Route("/admin/tickets/transition", name="admin_ticket_transition")
     */
    public function transitionAction(Request $request)
    {
        /** @var TicketManager $ticketManager */
        $ticketManager = $this->get('app.manager.ticket');

        if (($ticket = $ticketManager->findByHumanId($request->get('id'))) === null) {
            return $this->createNotFoundException();
        }

        $this->denyAccessUnlessGranted(TicketVoter::REPLY, $ticket);

        /** @var  WorkflowTransitionManager $transitionManager */
        $transitionManager  = $this->get('app.manager.workflow_transition');
        $transition = $transitionManager->findById($request->get('transition'));

        $transitionManager->transitionTicket($ticket, $transition, $ticketManager);

<<<<<<< HEAD
        return $this->redirect($this->generateUrl('view_ticket', ['id' => $ticket->getResourceId()]));
=======
        return $this->redirect($this->generateUrl('view_ticket', ['id' => $ticket->getHumanId()]));
>>>>>>> e9e64361644b998e6348ba74050a34dd3565fb8b
    }
}