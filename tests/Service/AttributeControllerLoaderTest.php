<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouteCollection;
use WechatStoreBundle\Controller\ServerController;
use WechatStoreBundle\Exception\InvalidClassException;
use WechatStoreBundle\Service\AttributeControllerLoader;

final class AttributeControllerLoaderTest extends TestCase
{
    private AttributeControllerLoader $loader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loader = new AttributeControllerLoader();
    }

    public function testLoadWithValidClass(): void
    {
        $collection = $this->loader->load(ServerController::class);
        
        self::assertInstanceOf(RouteCollection::class, $collection);
    }

    public function testLoadWithInvalidClass(): void
    {
        $this->expectException(InvalidClassException::class);
        $this->expectExceptionMessage('Class "NonExistentClass" does not exist.');
        
        $this->loader->load('NonExistentClass');
    }

    public function testLoadWithNonStringClass(): void
    {
        $this->expectException(InvalidClassException::class);
        
        $this->loader->load(123);
    }

    public function testAutoload(): void
    {
        $collection = new RouteCollection();
        
        AttributeControllerLoader::autoload($collection);
        
        self::assertGreaterThanOrEqual(0, $collection->count());
    }
}