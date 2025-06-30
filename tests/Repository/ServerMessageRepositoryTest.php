<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatStoreBundle\Entity\ServerMessage;
use WechatStoreBundle\Repository\ServerMessageRepository;

final class ServerMessageRepositoryTest extends TestCase
{
    private ServerMessageRepository $repository;
    private ManagerRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = $this->createMock(ManagerRegistry::class);
        $this->repository = new ServerMessageRepository($this->registry);
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(ServerMessageRepository::class, $this->repository);
    }

}