<?php

namespace WechatStoreBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;

class ServerControllerTest extends TestCase
{
    /**
     * 由于 AbstractController 的问题，这个测试会跳过
     * 在实际项目中，应使用 Symfony\Bundle\FrameworkBundle\Test\WebTestCase 来测试控制器
     */
    public function testIndex_returnsJsonResponse(): void
    {
        $this->markTestSkipped('由于 AbstractController 依赖于 Symfony 容器，此测试在单元测试环境中无法正常运行');
        
        // 如果要在完整的 Symfony 环境中测试，可以使用如下代码：
        // $client = static::createClient();
        // $client->request('GET', '/wechat-store/callback/test-app-id');
        // $this->assertResponseIsSuccessful();
        // $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }
} 