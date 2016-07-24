<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

$container->setDefinition('app.manager.ticket',
    (new Definition(\AppBundle\Entity\Ticket\TicketManager::class))
        ->setArguments([
            new Reference('event_dispatcher'),
            new Reference('doctrine.orm.entity_manager'),
            new Reference('app.utils.human_id_helper'),
            \AppBundle\Entity\Ticket\Ticket::class,
        ])
);

$container->setDefinition('app.manager.ticket_reply',
    (new Definition(\AppBundle\Entity\TicketReply\TicketReplyManager::class))
        ->setArguments([
            new Reference('event_dispatcher'),
            new Reference('doctrine.orm.entity_manager'),
            \AppBundle\Entity\TicketReply\TicketReply::class,
        ])
);

$container->setDefinition('app.manager.workflow_transition',
    (new Definition(\AppBundle\Entity\WorkflowTransition\WorkflowTransitionManager::class))
        ->setArguments([
            new Reference('event_dispatcher'),
            new Reference('doctrine.orm.entity_manager'),
            \AppBundle\Entity\WorkflowTransition\WorkflowTransition::class,
        ])
);