<?php

namespace WechatStoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class WechatStoreExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->setParameter('wechat_store.bundle_dir', dirname(__DIR__, 2));
        
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');
    }
}
