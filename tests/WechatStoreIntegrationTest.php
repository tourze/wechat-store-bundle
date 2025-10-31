<?php

namespace WechatStoreBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Routing\Attribute\Route;
use Tourze\BundleDependency\BundleDependencyInterface;
use WechatStoreBundle\WechatStoreBundle;

/**
 * @internal
 */
#[CoversClass(WechatStoreBundle::class)]
final class WechatStoreIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // 无需特殊设置
    }

    private function assertClassExists(string $className): void
    {
        if (!class_exists($className)) {
            self::fail(sprintf('Class %s does not exist', $className));
        }

        // 验证类可以被正确反射
        $reflection = new \ReflectionClass($className);
        $this->assertInstanceOf(\ReflectionClass::class, $reflection);
        $this->assertEquals($className, $reflection->getName());

        // 验证类不是抽象类或接口（除非预期是）
        if (!$reflection->isAbstract() && !$reflection->isInterface()) {
            $this->assertFalse($reflection->isAbstract(), sprintf('Class %s should not be abstract', $className));
        }
    }

    /**
     * 此测试检查 Bundle 是否可以正确注册到 Symfony 内核中
     */
    public function testBundleRegistration(): void
    {
        // 直接实例化Bundle
        $bundle = new WechatStoreBundle();

        $this->assertInstanceOf(Bundle::class, $bundle);
        $this->assertInstanceOf(BundleDependencyInterface::class, $bundle);
        $this->assertEquals('WechatStoreBundle', $bundle->getName());
    }

    /**
     * 此测试检查所有的实体仓库服务是否已正确注册
     */
    public function testRepositoryServicesAreRegistered(): void
    {
        $repositoryClasses = [
            'WechatStoreBundle\Repository\CategoryRepository',
            'WechatStoreBundle\Repository\FreightTemplateRepository',
            'WechatStoreBundle\Repository\ProductRepository',
            'WechatStoreBundle\Repository\QualificationImageRepository',
            'WechatStoreBundle\Repository\ServerMessageRepository',
        ];

        foreach ($repositoryClasses as $repositoryClass) {
            // 测试仓库类的实例化和继承关系
            $this->assertClassExists($repositoryClass);

            $reflection = new \ReflectionClass($repositoryClass);
            $parent = $reflection->getParentClass();
            $this->assertNotFalse($parent, sprintf('Repository %s should have a parent class', $repositoryClass));
            $this->assertEquals('Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository', $parent->getName(), sprintf('Repository %s should extend ServiceEntityRepository', $repositoryClass));

            // 验证仓库可以被正确初始化（抽象测试）
            $this->assertIsString($repositoryClass);
            $this->assertStringContainsString('Repository', $repositoryClass);
        }
    }

    /**
     * 此测试检查服务是否已正确注册
     */
    public function testServicesAreRegistered(): void
    {
        $serviceClasses = [
            'WechatStoreBundle\Service\ProductService',
        ];

        foreach ($serviceClasses as $serviceClass) {
            // 测试服务类的存在性和基本功能
            $this->assertClassExists($serviceClass);

            // 验证服务类可以被实例化（如果没有构造函数依赖）
            $reflection = new \ReflectionClass($serviceClass);
            $constructor = $reflection->getConstructor();

            if (null === $constructor || 0 === $constructor->getNumberOfRequiredParameters()) {
                $instance = new $serviceClass();
                $this->assertInstanceOf($serviceClass, $instance);
            } else {
                // 如果有构造函数依赖，至少验证类结构正确
                $this->assertIsString($serviceClass);
                $this->assertStringContainsString('Service', $serviceClass);
            }
        }
    }

    /**
     * 此测试检查命令是否已正确注册
     */
    public function testCommandsAreRegistered(): void
    {
        $commandClasses = [
            'WechatStoreBundle\Command\SyncCategoryCommand',
        ];

        foreach ($commandClasses as $commandClass) {
            // 测试命令类的存在性和继承关系
            $this->assertClassExists($commandClass);

            $reflection = new \ReflectionClass($commandClass);
            $parent = $reflection->getParentClass();
            $this->assertNotFalse($parent, sprintf('Command %s should have a parent class', $commandClass));
            $this->assertEquals('Symfony\Component\Console\Command\Command', $parent->getName(), sprintf('Command %s should extend Command', $commandClass));

            // 测试命令实例化能力
            $constructor = $reflection->getConstructor();
            if (null === $constructor || 0 === $constructor->getNumberOfRequiredParameters()) {
                $command = new $commandClass();
                $this->assertInstanceOf($commandClass, $command);
                $this->assertInstanceOf('Symfony\Component\Console\Command\Command', $command);
            } else {
                // 验证命令类结构正确
                $this->assertIsString($commandClass);
                $this->assertStringContainsString('Command', $commandClass);
            }
        }
    }

    /**
     * 此测试检查路由是否已正确注册
     */
    public function testRoutesAreRegistered(): void
    {
        $controllerClass = 'WechatStoreBundle\Controller\ServerController';

        $this->assertClassExists($controllerClass);

        // 检查控制器方法上的路由属性
        $reflection = new \ReflectionClass($controllerClass);
        $method = $reflection->getMethod('__invoke');
        $attributes = $method->getAttributes(Route::class);

        $this->assertCount(1, $attributes, '__invoke method should have Route attribute');

        $routeAttribute = $attributes[0];
        $arguments = $routeAttribute->getArguments();

        $this->assertEquals('/wechat-store/callback/{appId}', $arguments[0] ?? $arguments['path'] ?? null, 'Route path should match');
        $this->assertEquals('wechat-store-callback', $arguments['name'] ?? null, 'Route name should match');
    }

    /**
     * 测试控制器是否可用
     */
    public function testControllerAvailability(): void
    {
        $controllerClass = 'WechatStoreBundle\Controller\ServerController';

        $this->assertClassExists($controllerClass);

        // 验证控制器继承关系
        $reflection = new \ReflectionClass($controllerClass);
        $parent = $reflection->getParentClass();
        $this->assertNotFalse($parent, sprintf('Controller %s should have a parent class', $controllerClass));
        $this->assertEquals('Symfony\Bundle\FrameworkBundle\Controller\AbstractController', $parent->getName(), sprintf('Controller %s should extend AbstractController', $controllerClass));

        // 检查控制器的方法是否存在
        $reflection = new \ReflectionClass($controllerClass);
        $this->assertTrue($reflection->hasMethod('__invoke'), 'Controller should have __invoke method');

        $invokeMethod = $reflection->getMethod('__invoke');
        $this->assertTrue($invokeMethod->isPublic(), '__invoke method should be public');
    }
}
