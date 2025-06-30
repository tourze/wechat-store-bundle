<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WechatStoreBundle\DependencyInjection\WechatStoreExtension;

final class WechatStoreExtensionTest extends TestCase
{
    private WechatStoreExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->extension = new WechatStoreExtension();
        $this->container = new ContainerBuilder();
    }

    public function testLoad(): void
    {
        $this->extension->load([], $this->container);
        
        self::assertTrue($this->container->hasParameter('wechat_store.bundle_dir'));
        self::assertSame(dirname(__DIR__, 2), $this->container->getParameter('wechat_store.bundle_dir'));
    }
}