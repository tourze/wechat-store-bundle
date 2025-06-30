<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatStoreBundle\Entity\Product;
use WechatStoreBundle\Repository\ProductRepository;

final class ProductRepositoryTest extends TestCase
{
    private ProductRepository $repository;
    private ManagerRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = $this->createMock(ManagerRegistry::class);
        $this->repository = new ProductRepository($this->registry);
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(ProductRepository::class, $this->repository);
    }

}