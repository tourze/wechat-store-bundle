<?php

namespace WechatStoreBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatStoreBundle\Entity\QualificationImage;

/**
 * @internal
 */
#[CoversClass(QualificationImage::class)]
final class QualificationImageTest extends AbstractEntityTestCase
{
    protected function createEntity(): QualificationImage
    {
        return new QualificationImage();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'id' => ['id', '123'],
        ];
    }

    public function testToStringReturnsId(): void
    {
        $entity = $this->createEntity();
        $stringValue = $entity->__toString();
        $this->assertIsString($stringValue);
    }
}
