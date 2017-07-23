<?php

namespace Liz\WeiXinBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('liz_wx');
        $rootNode
            ->children()
                ->arrayNode('base')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('token')->defaultValue('token')->cannotBeEmpty()->end()
                        ->scalarNode('app_id')->defaultValue('app_id')->cannotBeEmpty()->end()
                        ->scalarNode('app_secret')->defaultValue('app_secret')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()
        ;
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
