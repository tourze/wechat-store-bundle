<?php

namespace WechatStoreBundle\Tests\Entity;

use WechatStoreBundle\Entity\FreightTemplate;

class FreightTemplateTest extends AbstractEntityTestCase
{
    protected function getEntityClass(): string
    {
        return FreightTemplate::class;
    }
    
    /**
     * 额外测试 - 特定于 FreightTemplate 实体的测试用例可以在这里添加
     */
} 