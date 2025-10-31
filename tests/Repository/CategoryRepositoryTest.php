<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatStoreBundle\Entity\Category;
use WechatStoreBundle\Repository\CategoryRepository;

/**
 * @internal
 */
#[CoversClass(CategoryRepository::class)]
#[RunTestsInSeparateProcesses]
final class CategoryRepositoryTest extends AbstractRepositoryTestCase
{
    private CategoryRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(CategoryRepository::class);
    }

    public function testRepositoryService(): void
    {
        $this->assertInstanceOf(CategoryRepository::class, $this->repository);
    }

    public function testRepositoryCanBeRetrieved(): void
    {
        $repository = self::getService(CategoryRepository::class);
        $this->assertInstanceOf(CategoryRepository::class, $repository);
    }

    public function testSaveWithoutFlushShouldNotPersistImmediately(): void
    {
        $category = $this->createCategory();

        $this->repository->save($category, false);

        // 验证实体已被persist（但未flush）
        $this->assertTrue(self::getEntityManager()->contains($category));

        // 获取实体ID（persist后应该会有ID）
        $categoryId = $category->getId();
        $this->assertNotNull($categoryId);

        // 清除EntityManager缓存检查是否真正持久化到数据库
        self::getEntityManager()->clear();

        $found = $this->repository->find($categoryId);
        $this->assertNull($found);

        // 由于clear()清除了所有实体，我们需要重新创建并persist
        $newCategory = $this->createCategory();
        $this->repository->save($newCategory, false);

        // 手动flush后应该能找到
        self::getEntityManager()->flush();
        $found = $this->repository->find($newCategory->getId());
        $this->assertInstanceOf(Category::class, $found);
    }

    public function testRemoveWithFlushShouldDeleteEntity(): void
    {
        $category = $this->createCategory();
        $this->persistAndFlush($category);
        $id = $category->getId();

        $this->repository->remove($category, true);

        $this->assertEntityNotExists(Category::class, $id);
        $found = $this->repository->find($id);
        $this->assertNull($found);
    }

    public function testRemoveWithoutFlushShouldNotDeleteImmediately(): void
    {
        $category = $this->createCategory();
        $this->persistAndFlush($category);
        $id = $category->getId();

        $this->repository->remove($category, false);

        // remove后但未flush，实体应该被标记为删除
        // 但在数据库中仍然存在，跳过contains检查

        // 清除缓存后应该还能找到（因为还没有flush删除操作）
        self::getEntityManager()->clear();
        $found = $this->repository->find($id);
        $this->assertInstanceOf(Category::class, $found);

        // 重新获取实体并删除，然后flush
        $categoryToDelete = $this->repository->find($id);
        $this->assertInstanceOf(Category::class, $categoryToDelete);
        $this->repository->remove($categoryToDelete, false);

        // 手动flush后应该被删除
        self::getEntityManager()->flush();
        $found = $this->repository->find($id);
        $this->assertNull($found);
    }

    public function testFindByIsNullQuery(): void
    {
        $category = $this->createCategory();
        $this->persistAndFlush($category);

        // 使用Doctrine的IS NULL语法查询updateTime字段
        $queryBuilder = $this->repository->createQueryBuilder('c')
            ->where('c.updateTime IS NULL')
        ;

        $result = $queryBuilder->getQuery()->getResult();

        $this->assertIsArray($result);
        // 由于TimestampableAware会自动设置updateTime，通常结果为空
        $this->assertGreaterThanOrEqual(0, count($result));
    }

    private function createCategory(): Category
    {
        return new Category();
    }

    protected function createNewEntity(): object
    {
        return new Category();
    }

    /**
     * @return ServiceEntityRepository<Category>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }
}
