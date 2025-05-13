<?php

namespace WechatStoreBundle\Tests\Entity;

use WechatStoreBundle\Entity\Product;

class ProductTest extends AbstractEntityTest
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }
    
    /**
     * 额外测试 - 特定于 Product 实体的测试用例可以在这里添加
     */
} 