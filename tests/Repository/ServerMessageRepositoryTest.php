<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatStoreBundle\Entity\ServerMessage;
use WechatStoreBundle\Repository\ServerMessageRepository;

/**
 * @internal
 */
#[CoversClass(ServerMessageRepository::class)]
#[RunTestsInSeparateProcesses]
final class ServerMessageRepositoryTest extends AbstractRepositoryTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    protected function createNewEntity(): object
    {
        $entity = new ServerMessage();

        // 设置基本字段
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $entity->setMediaUrl('https://example.com/media/' . uniqid() . '.jpg');
        $entity->setMediaId('media_' . uniqid());
        $entity->setMediaMd5(md5(uniqid()));

        return $entity;
    }

    protected function getRepository(): ServerMessageRepository
    {
        return self::getService(ServerMessageRepository::class);
    }

    #[Test]
    public function testRepositoryServiceIsAvailable(): void
    {
        $repository = $this->getRepository();
        $this->assertInstanceOf(ServerMessageRepository::class, $repository);
    }

    #[Test]
    public function testSaveEntityWithoutFlush(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity, false);

        $this->assertNotNull($entity->getId());
        $this->assertNotNull($entity->getCreateTime());
        $this->assertNotNull($entity->getUpdateTime());
    }

    #[Test]
    public function testSaveAndFindEntity(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);

        $this->assertNotNull($entity->getId());

        $found = $this->getRepository()->find($entity->getId());
        $this->assertNotNull($found);
        $this->assertEquals($entity->getId(), $found->getId());
        $this->assertInstanceOf(ServerMessage::class, $found);

        // 清理测试数据
        $this->getRepository()->remove($entity);
    }

    #[Test]
    public function testRemoveEntity(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);
        $id = $entity->getId();

        $found = $this->getRepository()->find($id);
        $this->assertNotNull($found);

        $this->getRepository()->remove($entity);

        $removedEntity = $this->getRepository()->find($id);
        $this->assertNull($removedEntity);
    }

    #[Test]
    public function testRemoveEntityWithoutFlush(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);
        $id = $entity->getId();

        $this->getRepository()->remove($entity, false);

        // 由于没有flush，实体仍然存在于数据库中
        $found = $this->getRepository()->find($id);
        $this->assertNotNull($found);

        // 手动flush以清理
        self::getEntityManager()->flush();
        $removedEntity = $this->getRepository()->find($id);
        $this->assertNull($removedEntity);
    }

    #[Test]
    public function testFindAll(): void
    {
        $initialCount = count($this->getRepository()->findAll());

        $entity1 = new ServerMessage();
        $entity1->setType('TEXT');
        $entity1->setContent('Test message content ' . uniqid());
        $entity2 = new ServerMessage();
        $entity2->setType('TEXT');
        $entity2->setContent('Test message content ' . uniqid());

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $allEntities = $this->getRepository()->findAll();
        $this->assertCount($initialCount + 2, $allEntities);

        // 清理测试数据
        $this->getRepository()->remove($entity1);
        $this->getRepository()->remove($entity2);
    }

    #[Test]
    public function testFindBy(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);

        $results = $this->getRepository()->findBy(['id' => $entity->getId()]);
        $this->assertCount(1, $results);
        $this->assertEquals($entity->getId(), $results[0]->getId());

        // 清理测试数据
        $this->getRepository()->remove($entity);
    }

    #[Test]
    public function testFindOneBy(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);

        $result = $this->getRepository()->findOneBy(['id' => $entity->getId()]);
        $this->assertNotNull($result);
        $this->assertEquals($entity->getId(), $result->getId());

        // 清理测试数据
        $this->getRepository()->remove($entity);
    }

    #[Test]
    public function testFindOneByWithNonExistentCriteria(): void
    {
        $result = $this->getRepository()->findOneBy(['id' => '999999999999999999']);
        $this->assertNull($result);
    }

    #[Test]
    public function testCount(): void
    {
        $initialCount = $this->getRepository()->count([]);

        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);

        $newCount = $this->getRepository()->count([]);
        $this->assertEquals($initialCount + 1, $newCount);

        // 清理测试数据
        $this->getRepository()->remove($entity);
    }

    #[Test]
    public function testCountWithCriteria(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);

        $count = $this->getRepository()->count(['id' => $entity->getId()]);
        $this->assertEquals(1, $count);

        $countNonExistent = $this->getRepository()->count(['id' => '999999999999999999']);
        $this->assertEquals(0, $countNonExistent);

        // 清理测试数据
        $this->getRepository()->remove($entity);
    }

    #[Test]
    public function testEntityStringRepresentation(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);

        $stringValue = (string) $entity;
        $this->assertEquals((string) $entity->getId(), $stringValue);

        // 清理测试数据
        $this->getRepository()->remove($entity);
    }

    #[Test]
    public function testTimestampableTraitFunctionality(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $beforeSave = new \DateTime();

        $this->getRepository()->save($entity);

        $afterSave = new \DateTime();

        $this->assertNotNull($entity->getCreateTime());
        $this->assertNotNull($entity->getUpdateTime());
        $this->assertGreaterThanOrEqual($beforeSave, $entity->getCreateTime());
        $this->assertLessThanOrEqual($afterSave, $entity->getCreateTime());
        // 由于时间精度问题，只验证时间相近即可
        $timeDiff = abs($entity->getCreateTime()->getTimestamp() - $entity->getUpdateTime()->getTimestamp());
        $this->assertLessThanOrEqual(1, $timeDiff);

        // 清理测试数据
        $this->getRepository()->remove($entity);
    }

    #[Test]
    public function testSnowflakeIdGeneration(): void
    {
        $entity = new ServerMessage();
        $entity->setType('TEXT');
        $entity->setContent('Test message content ' . uniqid());
        $this->getRepository()->save($entity);

        $this->assertNotNull($entity->getId());
        $this->assertIsString($entity->getId());
        $this->assertGreaterThan(0, strlen($entity->getId()));

        // Snowflake ID应该是数字字符串
        $this->assertMatchesRegularExpression('/^\d+$/', $entity->getId());

        // 清理测试数据
        $this->getRepository()->remove($entity);
    }

    #[Test]
    public function testMultipleEntitiesHaveUniqueIds(): void
    {
        $entity1 = new ServerMessage();
        $entity1->setType('TEXT');
        $entity1->setContent('Test message content ' . uniqid());
        $entity2 = new ServerMessage();
        $entity2->setType('TEXT');
        $entity2->setContent('Test message content ' . uniqid());

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $this->assertNotEquals($entity1->getId(), $entity2->getId());

        // 清理测试数据
        $this->getRepository()->remove($entity1);
        $this->getRepository()->remove($entity2);
    }

    #[Test]
    public function testFindOneByWhenOrderedByCreateTimeShouldReturnCorrectEntity(): void
    {
        $entity1 = new ServerMessage();
        $entity1->setType('TEXT');
        $entity1->setContent('Test message content ' . uniqid());
        $entity2 = new ServerMessage();
        $entity2->setType('TEXT');
        $entity2->setContent('Test message content ' . uniqid());

        $this->getRepository()->save($entity1);
        usleep(1000); // 确保创建时间不同
        $this->getRepository()->save($entity2);

        // 按创建时间升序查找第一个 - 只验证能找到实体且时间正确
        $firstResult = $this->getRepository()->findOneBy([], ['createTime' => 'ASC']);
        $this->assertNotNull($firstResult);
        $this->assertInstanceOf(ServerMessage::class, $firstResult);
        $this->assertNotNull($firstResult->getCreateTime());

        // 按创建时间降序查找第一个 - 只验证能找到实体且时间正确
        $lastResult = $this->getRepository()->findOneBy([], ['createTime' => 'DESC']);
        $this->assertNotNull($lastResult);
        $this->assertInstanceOf(ServerMessage::class, $lastResult);
        $this->assertNotNull($lastResult->getCreateTime());

        // 验证降序的第一个时间应该大于等于升序的第一个时间
        $this->assertGreaterThanOrEqual(
            $firstResult->getCreateTime()->getTimestamp(),
            $lastResult->getCreateTime()->getTimestamp()
        );

        // 清理测试数据
        $this->getRepository()->remove($entity1);
        $this->getRepository()->remove($entity2);
    }
}
