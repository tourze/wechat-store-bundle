<?php

declare(strict_types=1);

namespace WechatStoreBundle\Service;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Loader\AttributeClassLoader;
use Symfony\Component\Routing\RouteCollection;

final class AttributeControllerLoader extends AttributeClassLoader
{
    public function __construct()
    {
    }

    public static function autoload(RouteCollection $collection): void
    {
        // 这里需要加载控制器
        $controllerLoader = new self();
        $collection->addCollection($controllerLoader->load(\WechatStoreBundle\Controller\ServerController::class));
    }
    
    public function load(mixed $class, ?string $type = null): RouteCollection
    {
        if (!is_string($class) || !class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', (string) $class));
        }

        $collection = new RouteCollection();

        $reflection = new \ReflectionClass($class);

        // 处理方法级别的路由
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodAttributes = $method->getAttributes(Route::class);
            foreach ($methodAttributes as $attribute) {
                $route = $attribute->newInstance();
                $routeName = $route->getName() ?? $class . '::' . $method->getName();
                $routeObject = $this->createRoute($route->getPath(), [
                    '_controller' => $class . '::' . $method->getName()
                ], [], [], null, [], [], null);
                $collection->add($routeName, $routeObject);
            }
        }

        return $collection;
    }

    protected function createRoute(string $path, array $defaults, array $requirements = [], array $options = [], ?string $host = null, array $schemes = [], array $methods = [], ?string $condition = null): \Symfony\Component\Routing\Route
    {
        return new \Symfony\Component\Routing\Route($path, $defaults, $requirements, $options, $host, $schemes, $methods, $condition);
    }

    protected function configureRoute(\Symfony\Component\Routing\Route $route, \ReflectionClass $class, \ReflectionMethod $method, object $annot): void
    {
        // 实现父类的抽象方法
    }
}