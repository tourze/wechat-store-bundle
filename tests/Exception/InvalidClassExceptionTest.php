<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use WechatStoreBundle\Exception\InvalidClassException;

/**
 * @internal
 */
#[CoversClass(InvalidClassException::class)]
final class InvalidClassExceptionTest extends AbstractExceptionTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // 无需特殊设置
    }

    public function testClassNotFound(): void
    {
        $className = 'NonExistentClass';
        $exception = InvalidClassException::classNotFound($className);

        $this->assertInstanceOf(InvalidClassException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertSame('Class "NonExistentClass" does not exist.', $exception->getMessage());
    }

    public function testExceptionCanBeCreated(): void
    {
        $exception = new InvalidClassException('Test message');
        $this->assertInstanceOf(InvalidClassException::class, $exception);
        $this->assertSame('Test message', $exception->getMessage());
    }
}
