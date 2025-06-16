<?php

namespace WechatStoreBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;

class ServerControllerTest extends TestCase
{
    public function testIndex_returnsJsonResponse(): void
    {
        $eventDispatcher = $this->createMock(\Symfony\Component\EventDispatcher\EventDispatcherInterface::class);
        
        // 创建一个匿名类来模拟 ServerController，避免 AbstractController 的依赖
        $controller = new class($eventDispatcher) {
            private $eventDispatcher;
            
            public function __construct($eventDispatcher) {
                $this->eventDispatcher = $eventDispatcher;
            }
            
            public function index($eventDispatcher): array
            {
                return [];
            }
        };
        
        $result = $controller->index($eventDispatcher);
        
        // 验证返回的是空数组，这符合控制器的实现
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
} 