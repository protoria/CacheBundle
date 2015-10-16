<?php
namespace Igdr\Bundle\CacheBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class IgdrCacheExtension
 */
class IgdrCacheExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        //load configuration
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        //store to config
        $container->setParameter('igdr_manager.config.cache_provider', isset($config['cache_provider']) ? $config['cache_provider'] : null);
        $container->getDefinition('igdr_cache.manager.cache')->replaceArgument(2, $config['lifetime']);

        return $configs;
    }
}
