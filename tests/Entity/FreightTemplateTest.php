<?php

namespace WechatStoreBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatStoreBundle\Entity\FreightTemplate;

/**
 * @internal
 */
#[CoversClass(FreightTemplate::class)]
final class FreightTemplateTest extends AbstractEntityTestCase
{
    protected function createEntity(): FreightTemplate
    {
        return new FreightTemplate();
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
