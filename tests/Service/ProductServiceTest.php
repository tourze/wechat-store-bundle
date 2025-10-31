<?php

namespace WechatStoreBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use WechatStoreBundle\Service\ProductService;

/**
 * @internal
 */
#[CoversClass(ProductService::class)]
#[RunTestsInSeparateProcesses]
final class ProductServiceTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    public function testAddMethodWorksCorrectly(): void
    {
        $productService = self::getService(ProductService::class);

        // 由于 add 方法目前是空实现，我们只能测试它不抛出异常
        $productService->add();

        // 验证方法执行完成（即使返回void）
        $this->expectNotToPerformAssertions();
    }

    public function testInstanceCanBeCreated(): void
    {
        $productService = self::getService(ProductService::class);
        $this->assertInstanceOf(ProductService::class, $productService);
    }
}
