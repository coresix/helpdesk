<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

$container->setDefinition('app.repository.role',
    (new Definition(\Doctrine\ORM\EntityRepository::class))
        ->setFactory([new Reference('doctrine'), 'getRepository'])
        ->setArguments([\AppBundle\Entity\Role\Role::class])
);