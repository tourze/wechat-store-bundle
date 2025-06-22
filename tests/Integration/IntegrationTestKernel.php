<?php

namespace WechatStoreBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use WechatStoreBundle\WechatStoreBundle;

class IntegrationTestKernel extends Kernel
{
    use MicroKernelTrait;

    private array $configs = [];

    public function __construct(array $configs = [])
    {
        parent::__construct('test', true);
        
        $this->configs = $configs;
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new WechatStoreBundle(),
        ];
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->loadFromExtension('framework', [
            'test' => true,
            'secret' => 'test-secret',
        ]);

        // 添加自定义配置
        foreach ($this->configs as $name => $config) {
            $container->loadFromExtension($name, $config);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        // 可以在此添加路由配置
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/wechat-store-bundle/cache';
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/wechat-store-bundle/log';
    }
} 