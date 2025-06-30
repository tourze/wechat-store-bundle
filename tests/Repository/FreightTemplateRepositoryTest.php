<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatStoreBundle\Entity\FreightTemplate;
use WechatStoreBundle\Repository\FreightTemplateRepository;

final class FreightTemplateRepositoryTest extends TestCase
{
    private FreightTemplateRepository $repository;
    private ManagerRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = $this->createMock(ManagerRegistry::class);
        $this->repository = new FreightTemplateRepository($this->registry);
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(FreightTemplateRepository::class, $this->repository);
    }

}