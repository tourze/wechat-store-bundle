<?php

namespace WechatStoreBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatStoreBundle\Entity\Category;

/**
 * @internal
 */
#[CoversClass(Category::class)]
final class CategoryTest extends AbstractEntityTestCase
{
    protected function createEntity(): Category
    {
        return new Category();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        // 此实体只有 Trait 属性，为避免空 data provider 错误，测试 id 属性
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
