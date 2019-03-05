<?php

namespace MenuBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MenuExtension extends Extension
{
    /**
     * @param array            $config
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $bundles = $container->getParameter('kernel.bundles');

        $loader->load('services.yml');

        if (isset($bundles['SonataAdminBundle'])) {
            $loader->load('admin.yml');
        }
    }
}
