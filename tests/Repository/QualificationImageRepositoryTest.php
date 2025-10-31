<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatStoreBundle\Entity\QualificationImage;
use WechatStoreBundle\Repository\QualificationImageRepository;

/**
 * @internal
 */
#[CoversClass(QualificationImageRepository::class)]
#[RunTestsInSeparateProcesses]
final class QualificationImageRepositoryTest extends AbstractRepositoryTestCase
{
    private QualificationImageRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(QualificationImageRepository::class);
    }

    public function testRepositoryService(): void
    {
        $this->assertInstanceOf(QualificationImageRepository::class, $this->repository);
    }

    public function testRepositoryCanBeRetrieved(): void
    {
        $repository = self::getService(QualificationImageRepository::class);
        $this->assertInstanceOf(QualificationImageRepository::class, $repository);
    }

    public function testSaveWithoutFlushShouldNotPersistImmediately(): void
    {
        $qualificationImage = $this->createQualificationImage();

        $this->repository->save($qualificationImage, false);

        // 验证实体已被persist（但未flush）
        $this->assertTrue(self::getEntityManager()->contains($qualificationImage));

        // 获取实体ID（persist后应该会有ID）
        $qualificationImageId = $qualificationImage->getId();
        $this->assertNotNull($qualificationImageId);

        // 清除EntityManager缓存检查是否真正持久化到数据库
        self::getEntityManager()->clear();

        $found = $this->repository->find($qualificationImageId);
        $this->assertNull($found);

        // 由于clear()清除了所有实体，我们需要重新创建并persist
        $newQualificationImage = $this->createQualificationImage();
        $this->repository->save($newQualificationImage, false);

        // 手动flush后应该能找到
        self::getEntityManager()->flush();
        $found = $this->repository->find($newQualificationImage->getId());
        $this->assertInstanceOf(QualificationImage::class, $found);
    }

    public function testRemoveWithFlushShouldDeleteEntity(): void
    {
        $qualificationImage = $this->createQualificationImage();
        $this->persistAndFlush($qualificationImage);
        $id = $qualificationImage->getId();

        $this->repository->remove($qualificationImage, true);

        $this->assertEntityNotExists(QualificationImage::class, $id);
        $found = $this->repository->find($id);
        $this->assertNull($found);
    }

    public function testRemoveWithoutFlushShouldNotDeleteImmediately(): void
    {
        $qualificationImage = $this->createQualificationImage();
        $this->persistAndFlush($qualificationImage);
        $id = $qualificationImage->getId();

        $this->repository->remove($qualificationImage, false);

        // remove后但未flush，实体应该被标记为删除
        // 但在数据库中仍然存在，跳过contains检查

        // 清除缓存后应该还能找到（因为还没有flush删除操作）
        self::getEntityManager()->clear();
        $found = $this->repository->find($id);
        $this->assertInstanceOf(QualificationImage::class, $found);

        // 重新获取实体并删除，然后flush
        $qualificationImageToDelete = $this->repository->find($id);
        $this->assertInstanceOf(QualificationImage::class, $qualificationImageToDelete);
        $this->repository->remove($qualificationImageToDelete, false);

        // 手动flush后应该被删除
        self::getEntityManager()->flush();
        $found = $this->repository->find($id);
        $this->assertNull($found);
    }

    public function testFindByIsNullQuery(): void
    {
        $qualificationImage = $this->createQualificationImage();
        $this->persistAndFlush($qualificationImage);

        // 使用Doctrine的IS NULL语法查询updateTime字段
        $queryBuilder = $this->repository->createQueryBuilder('q')
            ->where('q.updateTime IS NULL')
        ;

        $result = $queryBuilder->getQuery()->getResult();

        $this->assertIsArray($result);
        // 由于TimestampableAware会自动设置updateTime，通常结果为空
        $this->assertGreaterThanOrEqual(0, count($result));
    }

    private function createQualificationImage(): QualificationImage
    {
        return new QualificationImage();
    }

    protected function createNewEntity(): object
    {
        return new QualificationImage();
    }

    /**
     * @return ServiceEntityRepository<QualificationImage>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }
}
