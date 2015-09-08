<?php
namespace Igdr\Bundle\CacheBundle;

use Igdr\Bundle\CacheBundle\DependencyInjection\Compiler\CachePass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class IgdrCacheBundle
 */
class IgdrCacheBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CachePass(), PassConfig::TYPE_OPTIMIZE);
    }
}
