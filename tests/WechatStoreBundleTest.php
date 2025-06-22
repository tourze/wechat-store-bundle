<?php

namespace WechatStoreBundle\Tests;

use PHPUnit\Framework\TestCase;
use WechatStoreBundle\WechatStoreBundle;

class WechatStoreBundleTest extends TestCase
{
    public function testGetBundleDependencies_returnsEmptyArray(): void
    {
        $dependencies = WechatStoreBundle::getBundleDependencies();
        
        // 验证返回值的特定属性
        $this->assertCount(0, $dependencies, 'Bundle dependencies should be empty');
    }
    
    public function testBundleInstance_canBeCreated(): void
    {
        $bundle = new WechatStoreBundle();
        
        $this->assertInstanceOf(WechatStoreBundle::class, $bundle);
    }
} 