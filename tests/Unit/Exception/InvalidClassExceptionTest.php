<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Unit\Exception;

use PHPUnit\Framework\TestCase;
use WechatStoreBundle\Exception\InvalidClassException;

final class InvalidClassExceptionTest extends TestCase
{
    public function testClassNotFound(): void
    {
        $className = 'NonExistentClass';
        $exception = InvalidClassException::classNotFound($className);
        
        $this->assertInstanceOf(InvalidClassException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertSame('Class "NonExistentClass" does not exist.', $exception->getMessage());
    }
}