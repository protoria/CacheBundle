<?php
namespace Igdr\Bundle\CacheBundle\Tests\DependencyInjection;

use Igdr\Bundle\CacheBundle\DependencyInjection\IgdrCacheExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class IgdrCacheExtensionTest
 */
class IgdrCacheExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testLoad()
    {
        $this->configuration = new ContainerBuilder();
        $loader              = new IgdrCacheExtension();
        $loader->load(array(), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }
}
