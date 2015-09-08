<?php
namespace Igdr\Bundle\CacheBundle\DependencyInjection\Compiler;

use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Registering services tagged with seo.text as actual seo texts parameters providers
 */
class CachePass implements CompilerPassInterface
{
    /**
     * Adds services tagges as presta.sitemap.listener as event listeners for
     * corresponding sitemap event
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @throws \InvalidArgumentException
     */
    public function process(ContainerBuilder $container)
    {
        $cacheProvider = $container->getParameter('igdr_manager.config.cache_provider');
        if (!$container->hasDefinition($cacheProvider) && !$container->hasAlias($cacheProvider)) {
            throw new InvalidArgumentException(sprintf('The cache provider "%s" does not exist.', $cacheProvider));
        }

        //add dependencies
        $cacheProvider = $container->getDefinition($cacheProvider);

        $container->getDefinition('igdr_cache.manager.cache')->replaceArgument(0, $cacheProvider);
        $container->getDefinition('igdr_cache.manager.tags')->replaceArgument(0, $cacheProvider);
    }
}
