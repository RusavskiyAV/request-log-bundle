<?php

namespace RusavskiyAV\RequestLogBundle\DependencyInjection;

use RusavskiyAV\RequestLogBundle\Controller\IndexController;
use RusavskiyAV\RequestLogBundle\EventListener\ResponseListener;
use RusavskiyAV\RequestLogBundle\RequestLogger;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class RusavskiyAVRequestLogExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container
            ->getDefinition(IndexController::class)
            ->setArgument(2, $config['timezone']);
        $container
            ->getDefinition(RequestLogger::class)
            ->setArgument(0, $config['path']);

        if (null !== $config['request_logger']) {
            $container
                ->getDefinition(ResponseListener::class)
                ->setArgument(0, new Reference($config['request_logger']));
            $container
                ->getDefinition(IndexController::class)
                ->setArgument(0, new Reference($config['request_logger']));
        }
    }

    public function getAlias(): string
    {
        return 'request_log';
    }
}
