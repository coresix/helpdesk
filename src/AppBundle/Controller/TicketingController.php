<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Department\Department;
use AppBundle\Entity\Ticket\TicketManager;
use AppBundle\Entity\TicketReply\TicketReplyManager;
use AppBundle\Entity\TicketStatus\TicketStatus;
use AppBundle\Entity\TicketType\TicketType;
use AppBundle\Entity\WorkflowTransition\WorkflowTransitionManager;
use AppBundle\Security\Voter\TicketVoter;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketingController extends Controller
{
    use CsrfTrait;
    use SecurityTrait;

    /**
     * {@inheritdoc}
     * @Route("/tickets/new", name="new_ticket")
     */
    public function newAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $csrfToken = $this->getCsrfToken();
        $departmentId = $request->get('_department');

        if ($departmentId === null) {
            $departments = $entityManager->getRepository(Department::class)->findAll();

            return $this->render(
                'AppBundle:Ticketing:new_ticketdepartments.html.twig',
                [
                    'csrf_token' => $csrfToken,
                    'departments' => $departments,
                ]
            );
        } elseif ($departmentId) {

            /** @var Department $department */
            $department = $entityManager->getRepository(Department::class)->find($departmentId);

            return $this->render(
                'AppBundle:Ticketing:new_ticketdata.html.twig',
                [
                    'csrf_token' => $csrfToken,
                    '_department' => $departmentId,
                    'departmentName' => $department->getName(),
                ]
            );
        }

        return new Response($request->get('_department'));
    }

    /**
     * {@inheritdoc}
     * @Route("/tickets/create", name="create_ticket")
     */
    public function createAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        /** @var Department $department */
        $department = $entityManager->getRepository(Department::class)->find($request->get('_department'));
        /** @var TicketStatus $status */
        $status = $entityManager->getRepository(TicketStatus::class)->find(1);
        /** @var TicketType $type */
        $type = $entityManager->getRepository(TicketType::class)->find(1);

        $manager = $this->getTicketManager();

        $ticket = $manager->createTicket(
            $department,
            $status,
            new \DateTime(),
            $type,
            $request->get('_priority'),
            $request->get('_subject'),
            $request->get('_message'),
            null,
            $this->getUser()
        );

        $manager->saveTicket($ticket);

        return $this->redirectToRoute('view_ticket', ['id' => $ticket->getId()]);
    }

    /**
     * {@inheritdoc}
     * @Route("/tickets/view", name="view_ticket")
     */
    public function viewAction(Request $request)
    {
        $manager = $this->getTicketManager();

        $ticket = $manager->findByHumanId($request->get('id'));

        if (!$ticket || $ticket->getHumanId() !== $request->get('id')) {
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
     * @Route("/tickets/addreply", name="ticket_addreply")
     */
    public function addReplyAction(Request $request)
    {
        $ticketManager = $this->getTicketManager();
        /** @var TicketReplyManager $replyManager */
        $replyManager  = $this->get('app.manager.ticket_reply');

        $ticket = $ticketManager->findByHumanId($request->get('id'));

        if (!$ticket) {
            return $this->createNotFoundException();
        }

        $this->denyAccessUnlessGranted(TicketVoter::REPLY, $ticket);

        $reply = $replyManager->createReply($ticket, $this->getUser(), $request->get('_message'));
        $replyManager->addReply($reply);

        return $this->redirect($this->generateUrl('view_ticket', ['id' => $ticket->getHumanId()]));
    }

    /**
     * {@inheritdoc}
     * @Route("/tickets/transition", name="ticket_transition")
     */
    public function transitionAction(Request $request)
    {
        $ticketManager = $this->getTicketManager();

        if (($ticket = $ticketManager->findByHumanId($request->get('id'))) === null) {
            return $this->createNotFoundException();
        }

        $this->denyAccessUnlessGranted(TicketVoter::REPLY, $ticket);

        /** @var  WorkflowTransitionManager $transitionManager */
        $transitionManager  = $this->get('app.manager.workflow_transition');
        $transition = $transitionManager->findById($request->get('transition'));

        $transitionManager->transitionTicket($ticket, $transition, $ticketManager);

        return $this->redirect($this->generateUrl('view_ticket', ['id' => $ticket->getHumanId()]));
    }

    /**
     * @return TicketManager
     */
    private function getTicketManager()
    {
        return $this->get('app.manager.ticket');
    }
}