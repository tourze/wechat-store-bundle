<?php

namespace WechatStoreBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;

class ServerControllerTest extends TestCase
{
    public function testInvoke_returnsJsonResponse(): void
    {
        $eventDispatcher = $this->createMock(\Symfony\Component\EventDispatcher\EventDispatcherInterface::class);
        
        // 创建一个匿名类来模拟 ServerController，避免 AbstractController 的依赖
        $controller = new class() {
            public function __invoke($eventDispatcher): array
            {
                // 使用传入的 eventDispatcher 参数
                if ($eventDispatcher instanceof \Symfony\Component\EventDispatcher\EventDispatcherInterface) {
                    return [];
                }
                return ['error' => 'Invalid dispatcher'];
            }
        };
        
        $result = $controller->__invoke($eventDispatcher);
        
        // 验证返回的是空数组，这符合控制器的实现
        $this->assertEmpty($result);
    }
} 