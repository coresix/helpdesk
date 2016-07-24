<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class AppExtension extends Extension
{

    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator([__DIR__.'/../Resources/config/services']);
        $loader = new PhpFileLoader($container, $fileLocator);
        $loader->load('all.php');
    }
}