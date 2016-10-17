<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

$container->setDefinition('app.utils.human_id_helper',
    (new Definition(\AppBundle\ResourceId\ResourceIdResolver::class))
);