<?php

namespace WechatStoreBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatStoreBundle\Entity\Product;

/**
 * @internal
 */
#[CoversClass(Product::class)]
final class ProductTest extends AbstractEntityTestCase
{
    protected function createEntity(): Product
    {
        return new Product();
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
