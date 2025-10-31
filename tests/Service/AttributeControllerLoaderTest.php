<?php

namespace WechatStoreBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Routing\RouteCollection;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use WechatStoreBundle\Service\AttributeControllerLoader;

/**
 * @internal
 */
#[CoversClass(AttributeControllerLoader::class)]
#[RunTestsInSeparateProcesses]
final class AttributeControllerLoaderTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    public function testSupportsAlwaysReturnsFalse(): void
    {
        $loader = self::getService(AttributeControllerLoader::class);

        self::assertFalse($loader->supports('any-resource'));
        self::assertFalse($loader->supports('any-resource', 'any-type'));
    }

    public function testInstanceHasCorrectType(): void
    {
        $loader = self::getService(AttributeControllerLoader::class);
        self::assertIsObject($loader);
        self::assertStringContainsString('AttributeControllerLoader', get_class($loader));
    }

    public function testAutoloadReturnsRouteCollection(): void
    {
        $loader = self::getService(AttributeControllerLoader::class);
        $collection = $loader->autoload();

        self::assertInstanceOf(RouteCollection::class, $collection);
        self::assertGreaterThan(0, $collection->count());
    }

    public function testLoadCallsAutoload(): void
    {
        $loader = self::getService(AttributeControllerLoader::class);
        $collection = $loader->load('any-resource');

        self::assertInstanceOf(RouteCollection::class, $collection);
        self::assertGreaterThan(0, $collection->count());
    }
}
