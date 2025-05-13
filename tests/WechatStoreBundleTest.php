<?php

namespace WechatStoreBundle\Tests;

use PHPUnit\Framework\TestCase;
use WechatStoreBundle\WechatStoreBundle;

class WechatStoreBundleTest extends TestCase
{
    public function testGetBundleDependencies_returnsArray(): void
    {
        $dependencies = WechatStoreBundle::getBundleDependencies();
        
        $this->assertIsArray($dependencies);
        // 当前没有依赖，所以数组应该为空
        $this->assertEmpty($dependencies);
    }
    
    public function testBundleInstance_canBeCreated(): void
    {
        $bundle = new WechatStoreBundle();
        
        $this->assertInstanceOf(WechatStoreBundle::class, $bundle);
    }
} 