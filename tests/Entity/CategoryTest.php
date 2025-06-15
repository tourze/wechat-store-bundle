<?php

namespace WechatStoreBundle\Tests\Entity;

use WechatStoreBundle\Entity\Category;

class CategoryTest extends AbstractEntityTestCase
{
    protected function getEntityClass(): string
    {
        return Category::class;
    }
    
    /**
     * 额外测试 - 特定于 Category 实体的测试用例可以在这里添加
     */
} 