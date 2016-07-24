<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

$container->setDefinition('security.role_hierarchy',
    (new Definition(\AppBundle\Security\Role\RoleHierarchy::class))
        ->setArguments([new Reference('app.repository.role')])
);

$container->register('app.ticket_voter', \AppBundle\Security\Voter\TicketVoter::class)
    ->setPublic(false)
    ->addTag('security.voter')
;