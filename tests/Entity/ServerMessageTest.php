<?php

namespace WechatStoreBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatStoreBundle\Entity\ServerMessage;

/**
 * @internal
 */
#[CoversClass(ServerMessage::class)]
final class ServerMessageTest extends AbstractEntityTestCase
{
    protected function createEntity(): ServerMessage
    {
        return new ServerMessage();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        yield 'type' => ['type', 'test-type'];
        yield 'content' => ['content', 'test content'];
        yield 'mediaUrl' => ['mediaUrl', 'https://example.com/media.jpg'];
        yield 'mediaId' => ['mediaId', 'media123'];
        yield 'mediaMd5' => ['mediaMd5', 'a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6'];
    }

    public function testToStringReturnsId(): void
    {
        $entity = $this->createEntity();
        $stringValue = $entity->__toString();
        $this->assertIsString($stringValue);
    }
}
