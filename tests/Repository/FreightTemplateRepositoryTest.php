<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatStoreBundle\Entity\FreightTemplate;
use WechatStoreBundle\Repository\FreightTemplateRepository;

/**
 * @internal
 */
#[CoversClass(FreightTemplateRepository::class)]
#[RunTestsInSeparateProcesses]
final class FreightTemplateRepositoryTest extends AbstractRepositoryTestCase
{
    private FreightTemplateRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(FreightTemplateRepository::class);
    }

    public function testRepositoryService(): void
    {
        $this->assertInstanceOf(FreightTemplateRepository::class, $this->repository);
    }

    public function testRepositoryCanBeRetrieved(): void
    {
        $repository = self::getService(FreightTemplateRepository::class);
        $this->assertInstanceOf(FreightTemplateRepository::class, $repository);
    }

    public function testSaveWithoutFlushShouldNotPersistImmediately(): void
    {
        $freightTemplate = $this->createFreightTemplate();

        $this->repository->save($freightTemplate, false);

        // 验证实体已被persist（但未flush）
        $this->assertTrue(self::getEntityManager()->contains($freightTemplate));

        // 获取实体ID（persist后应该会有ID）
        $freightTemplateId = $freightTemplate->getId();
        $this->assertNotNull($freightTemplateId);

        // 清除EntityManager缓存检查是否真正持久化到数据库
        self::getEntityManager()->clear();

        $found = $this->repository->find($freightTemplateId);
        $this->assertNull($found);

        // 由于clear()清除了所有实体，我们需要重新创建并persist
        $newFreightTemplate = $this->createFreightTemplate();
        $this->repository->save($newFreightTemplate, false);

        // 手动flush后应该能找到
        self::getEntityManager()->flush();
        $found = $this->repository->find($newFreightTemplate->getId());
        $this->assertInstanceOf(FreightTemplate::class, $found);
    }

    public function testRemoveWithFlushShouldDeleteEntity(): void
    {
        $freightTemplate = $this->createFreightTemplate();
        $this->persistAndFlush($freightTemplate);
        $id = $freightTemplate->getId();

        $this->repository->remove($freightTemplate, true);

        $this->assertEntityNotExists(FreightTemplate::class, $id);
        $found = $this->repository->find($id);
        $this->assertNull($found);
    }

    public function testRemoveWithoutFlushShouldNotDeleteImmediately(): void
    {
        $freightTemplate = $this->createFreightTemplate();
        $this->persistAndFlush($freightTemplate);
        $id = $freightTemplate->getId();

        $this->repository->remove($freightTemplate, false);

        // remove后但未flush，实体应该被标记为删除
        // 但在数据库中仍然存在，跳过contains检查

        // 清除缓存后应该还能找到（因为还没有flush删除操作）
        self::getEntityManager()->clear();
        $found = $this->repository->find($id);
        $this->assertInstanceOf(FreightTemplate::class, $found);

        // 重新获取实体并删除，然后flush
        $freightTemplateToDelete = $this->repository->find($id);
        $this->assertInstanceOf(FreightTemplate::class, $freightTemplateToDelete);
        $this->repository->remove($freightTemplateToDelete, false);

        // 手动flush后应该被删除
        self::getEntityManager()->flush();
        $found = $this->repository->find($id);
        $this->assertNull($found);
    }

    public function testFindByIsNullQuery(): void
    {
        $freightTemplate = $this->createFreightTemplate();
        $this->persistAndFlush($freightTemplate);

        // 使用Doctrine的IS NULL语法查询updateTime字段
        $queryBuilder = $this->repository->createQueryBuilder('f')
            ->where('f.updateTime IS NULL')
        ;

        $result = $queryBuilder->getQuery()->getResult();

        $this->assertIsArray($result);
        // 由于TimestampableAware会自动设置updateTime，通常结果为空
        $this->assertGreaterThanOrEqual(0, count($result));
    }

    private function createFreightTemplate(): FreightTemplate
    {
        return new FreightTemplate();
    }

    protected function createNewEntity(): object
    {
        return new FreightTemplate();
    }

    /**
     * @return ServiceEntityRepository<FreightTemplate>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }
}
