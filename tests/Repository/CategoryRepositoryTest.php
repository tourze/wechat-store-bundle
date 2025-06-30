<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatStoreBundle\Entity\Category;
use WechatStoreBundle\Repository\CategoryRepository;

final class CategoryRepositoryTest extends TestCase
{
    private CategoryRepository $repository;
    private ManagerRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = $this->createMock(ManagerRegistry::class);
        $this->repository = new CategoryRepository($this->registry);
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(CategoryRepository::class, $this->repository);
    }

}