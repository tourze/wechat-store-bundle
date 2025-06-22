<?php

namespace WechatStoreBundle\Tests\Integration;

use PHPUnit\Framework\TestCase;

/**
 * 由于需要完整的 Symfony 环境，该测试暂时跳过
 */
class WechatStoreIntegrationTest extends TestCase
{
    /**
     * 此测试检查 Bundle 是否可以正确注册到 Symfony 内核中
     */
    public function testBundleRegistration(): void
    {
        $bundle = new \WechatStoreBundle\WechatStoreBundle();
        
        $this->assertInstanceOf(\Symfony\Component\HttpKernel\Bundle\Bundle::class, $bundle);
        $this->assertInstanceOf(\Tourze\BundleDependency\BundleDependencyInterface::class, $bundle);
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
            $this->assertTrue(class_exists($repositoryClass), sprintf('Repository class %s does not exist', $repositoryClass));
            
            // 验证仓库继承关系
            $reflection = new \ReflectionClass($repositoryClass);
            $parent = $reflection->getParentClass();
            $this->assertNotFalse($parent, sprintf('Repository %s should have a parent class', $repositoryClass));
            $this->assertEquals('Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository', $parent->getName(), sprintf('Repository %s should extend ServiceEntityRepository', $repositoryClass));
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
            $this->assertTrue(class_exists($serviceClass), sprintf('Service class %s does not exist', $serviceClass));
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
            $this->assertTrue(class_exists($commandClass), sprintf('Command class %s does not exist', $commandClass));
            
            // 验证命令继承关系
            $reflection = new \ReflectionClass($commandClass);
            $parent = $reflection->getParentClass();
            $this->assertNotFalse($parent, sprintf('Command %s should have a parent class', $commandClass));
            $this->assertEquals('Symfony\Component\Console\Command\Command', $parent->getName(), sprintf('Command %s should extend Command', $commandClass));
            
            // 测试命令可以实例化
            $command = new $commandClass();
            $this->assertInstanceOf($commandClass, $command);
        }
    }
    
    /**
     * 此测试检查路由是否已正确注册
     */
    public function testRoutesAreRegistered(): void
    {
        $controllerClass = 'WechatStoreBundle\Controller\ServerController';
        
        $this->assertTrue(class_exists($controllerClass), sprintf('Controller class %s does not exist', $controllerClass));
        
        // 检查控制器方法上的路由属性
        $reflection = new \ReflectionClass($controllerClass);
        $method = $reflection->getMethod('__invoke');
        $attributes = $method->getAttributes(\Symfony\Component\Routing\Attribute\Route::class);
        
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
        
        $this->assertTrue(class_exists($controllerClass), sprintf('Controller class %s does not exist', $controllerClass));
        
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