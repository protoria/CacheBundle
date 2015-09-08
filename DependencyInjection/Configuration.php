<?php
namespace Igdr\Bundle\CacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html//cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder  = new TreeBuilder();
        $rootNode = $builder->root('igdr_cache', 'array');

        $rootNode
            ->children()
                ->scalarNode('cache_provider')->isRequired()->end()
            ->end();

        return $builder;
    }
}
