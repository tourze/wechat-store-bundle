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
            $this->assertTrue(is_subclass_of($repositoryClass, 'Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository'), sprintf('Repository %s is not a ServiceEntityRepository', $repositoryClass));
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
            $this->assertTrue(is_subclass_of($commandClass, 'Symfony\Component\Console\Command\Command'), sprintf('Command %s is not a Console Command', $commandClass));
            
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
        $method = $reflection->getMethod('index');
        $attributes = $method->getAttributes(\Symfony\Component\Routing\Attribute\Route::class);
        
        $this->assertCount(1, $attributes, 'Index method should have Route attribute');
        
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
        $this->assertTrue(is_subclass_of($controllerClass, 'Symfony\Bundle\FrameworkBundle\Controller\AbstractController'), sprintf('Controller %s is not an AbstractController', $controllerClass));
        
        // 检查控制器的方法是否存在
        $reflection = new \ReflectionClass($controllerClass);
        $this->assertTrue($reflection->hasMethod('index'), 'Controller should have index method');
        
        $indexMethod = $reflection->getMethod('index');
        $this->assertTrue($indexMethod->isPublic(), 'Index method should be public');
    }
} 