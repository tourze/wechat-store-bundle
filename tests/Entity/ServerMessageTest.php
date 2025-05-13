<?php

namespace WechatStoreBundle\Tests\Entity;

use WechatStoreBundle\Entity\ServerMessage;

class ServerMessageTest extends AbstractEntityTest
{
    protected function getEntityClass(): string
    {
        return ServerMessage::class;
    }
    
    /**
     * 额外测试 - 特定于 ServerMessage 实体的测试用例可以在这里添加
     */
    
    public function testImmutability_propertyRetentionAfterChange(): void
    {
        $message = $this->createEntity();
        $date1 = new \DateTime('2023-01-01 12:00:00');
        $date2 = new \DateTime('2023-01-02 12:00:00');
        
        $message->setCreateTime($date1);
        $this->assertSame($date1, $message->getCreateTime());
        
        $message->setCreateTime($date2);
        $this->assertSame($date2, $message->getCreateTime());
        $this->assertNotSame($date1, $message->getCreateTime());
    }
} 