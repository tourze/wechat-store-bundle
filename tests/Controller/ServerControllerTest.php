<?php

namespace WechatStoreBundle\Tests\Controller;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Tourze\PHPUnitSymfonyWebTest\AbstractWebTestCase;
use WechatStoreBundle\Controller\ServerController;

/**
 * @internal
 */
#[CoversClass(ServerController::class)]
#[RunTestsInSeparateProcesses]
final class ServerControllerTest extends AbstractWebTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    public function testControllerInstanceCanBeCreated(): void
    {
        $controller = new ServerController();
        $this->assertInstanceOf(ServerController::class, $controller);
    }

    #[DataProvider('provideNotAllowedMethods')]
    public function testMethodNotAllowed(string $method): void
    {
        $client = self::createClientWithDatabase();

        $this->expectException(MethodNotAllowedHttpException::class);
        $client->request($method, '/wechat-store/callback/test-app-id');
    }
}
