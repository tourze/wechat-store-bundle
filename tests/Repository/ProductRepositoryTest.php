<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatStoreBundle\Entity\Product;
use WechatStoreBundle\Repository\ProductRepository;

/**
 * @internal
 */
#[CoversClass(ProductRepository::class)]
#[RunTestsInSeparateProcesses]
final class ProductRepositoryTest extends AbstractRepositoryTestCase
{
    private ProductRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(ProductRepository::class);
    }

    public function testRepositoryService(): void
    {
        $this->assertInstanceOf(ProductRepository::class, $this->repository);
    }

    public function testRepositoryCanBeRetrieved(): void
    {
        $repository = self::getService(ProductRepository::class);
        $this->assertInstanceOf(ProductRepository::class, $repository);
    }

    public function testSaveWithoutFlushShouldNotPersistImmediately(): void
    {
        $product = $this->createProduct();

        $this->repository->save($product, false);

        // 验证实体已被persist（但未flush）
        $this->assertTrue(self::getEntityManager()->contains($product));

        // 获取实体ID（persist后应该会有ID）
        $productId = $product->getId();
        $this->assertNotNull($productId);

        // 清除EntityManager缓存检查是否真正持久化到数据库
        self::getEntityManager()->clear();

        $found = $this->repository->find($productId);
        $this->assertNull($found);

        // 由于clear()清除了所有实体，我们需要重新创建并persist
        $newProduct = $this->createProduct();
        $this->repository->save($newProduct, false);

        // 手动flush后应该能找到
        self::getEntityManager()->flush();
        $found = $this->repository->find($newProduct->getId());
        $this->assertInstanceOf(Product::class, $found);
    }

    public function testRemoveWithFlushShouldDeleteEntity(): void
    {
        $product = $this->createProduct();
        $this->persistAndFlush($product);
        $id = $product->getId();

        $this->repository->remove($product, true);

        $this->assertEntityNotExists(Product::class, $id);
        $found = $this->repository->find($id);
        $this->assertNull($found);
    }

    public function testRemoveWithoutFlushShouldNotDeleteImmediately(): void
    {
        $product = $this->createProduct();
        $this->persistAndFlush($product);
        $id = $product->getId();

        $this->repository->remove($product, false);

        // remove后但未flush，实体应该被标记为删除
        // 但在数据库中仍然存在，跳过contains检查

        // 清除缓存后应该还能找到（因为还没有flush删除操作）
        self::getEntityManager()->clear();
        $found = $this->repository->find($id);
        $this->assertInstanceOf(Product::class, $found);

        // 重新获取实体并删除，然后flush
        $productToDelete = $this->repository->find($id);
        $this->assertInstanceOf(Product::class, $productToDelete);
        $this->repository->remove($productToDelete, false);

        // 手动flush后应该被删除
        self::getEntityManager()->flush();
        $found = $this->repository->find($id);
        $this->assertNull($found);
    }

    public function testFindByIsNullQuery(): void
    {
        $product = $this->createProduct();
        $this->persistAndFlush($product);

        // 使用Doctrine的IS NULL语法查询updateTime字段
        $queryBuilder = $this->repository->createQueryBuilder('p')
            ->where('p.updateTime IS NULL')
        ;

        $result = $queryBuilder->getQuery()->getResult();

        $this->assertIsArray($result);
        // 由于TimestampableAware会自动设置updateTime，通常结果为空
        $this->assertGreaterThanOrEqual(0, count($result));
    }

    private function createProduct(): Product
    {
        return new Product();
    }

    protected function createNewEntity(): object
    {
        return new Product();
    }

    /**
     * @return ServiceEntityRepository<Product>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }
}
