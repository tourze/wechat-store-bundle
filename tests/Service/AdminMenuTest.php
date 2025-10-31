<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Service;

use Knp\Menu\ItemInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;
use WechatStoreBundle\Service\AdminMenu;

/**
 * 微信店铺管理后台菜单提供者测试
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
final class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    public function testInvokeMethod(): void
    {
        // 测试 AdminMenu 的 __invoke 方法正常工作
        $this->expectNotToPerformAssertions();

        try {
            $adminMenu = self::getService(AdminMenu::class);
            $item = $this->createMock(ItemInterface::class);
            ($adminMenu)($item);
        } catch (\Throwable $e) {
            self::fail('不应该抛出异常: ' . $e->getMessage());
        }
    }
}
