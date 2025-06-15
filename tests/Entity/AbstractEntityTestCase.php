<?php

namespace WechatStoreBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;

/**
 * 所有实体测试类的基类，提供通用的测试方法
 */
abstract class AbstractEntityTestCase extends TestCase
{
    /**
     * 获取要测试的实体类名
     * 
     * @return string
     */
    abstract protected function getEntityClass(): string;
    
    /**
     * 创建实体实例
     * 
     * @return object
     */
    protected function createEntity(): object
    {
        $className = $this->getEntityClass();
        return new $className();
    }
    
    /**
     * 测试实体的 createTime getter 和 setter
     */
    public function testCreateTime_getterAndSetter(): void
    {
        $entity = $this->createEntity();
        $date = new \DateTime();
        
        $entity->setCreateTime($date);
        $this->assertSame($date, $entity->getCreateTime());
    }
    
    /**
     * 测试实体的 updateTime getter 和 setter
     */
    public function testUpdateTime_getterAndSetter(): void
    {
        $entity = $this->createEntity();
        $date = new \DateTime();
        
        $entity->setUpdateTime($date);
        $this->assertSame($date, $entity->getUpdateTime());
    }
    
    /**
     * 测试实体的 ID getter
     */
    public function testId_getter(): void
    {
        $entity = $this->createEntity();
        $this->assertNull($entity->getId());
    }
    
    /**
     * 测试 createTime 为 null 时的情况
     */
    public function testCreateTime_withNullValue(): void
    {
        $entity = $this->createEntity();
        $entity->setCreateTime(null);
        $this->assertNull($entity->getCreateTime());
    }
    
    /**
     * 测试 updateTime 为 null 时的情况
     */
    public function testUpdateTime_withNullValue(): void
    {
        $entity = $this->createEntity();
        $entity->setUpdateTime(null);
        $this->assertNull($entity->getUpdateTime());
    }
    
    /**
     * 测试所有属性的默认值
     */
    public function testDefaultValues_areSetCorrectly(): void
    {
        $entity = $this->createEntity();
        $this->assertNull($entity->getCreateTime());
        $this->assertNull($entity->getUpdateTime());
        $this->assertNull($entity->getId());
    }
} 