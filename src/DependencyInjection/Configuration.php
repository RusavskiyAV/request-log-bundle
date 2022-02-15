<?php

namespace RusavskiyAV\RequestLogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('request_log');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
            ->scalarNode('timezone')
            ->defaultValue('UTC')
            ->info('Timezone для отображения на странице логов')
            ->end()
            ->scalarNode('path')
            ->defaultValue('%kernel.logs_dir%/%kernel.environment%_request_log.log')
            ->info('Файл лога')
            ->end()
            ->scalarNode('request_logger')
            ->defaultNull()
            ->end();

        return $treeBuilder;
    }
}
