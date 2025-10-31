<?php

declare(strict_types=1);

namespace WechatStoreBundle\Service;

use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use WechatStoreBundle\Entity\Category;
use WechatStoreBundle\Entity\FreightTemplate;
use WechatStoreBundle\Entity\Product;
use WechatStoreBundle\Entity\QualificationImage;
use WechatStoreBundle\Entity\ServerMessage;

/**
 * 微信店铺管理后台菜单提供者
 */
#[Autoconfigure(public: true)]
readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(
        private LinkGeneratorInterface $linkGenerator,
    ) {
    }

    public function __invoke(ItemInterface $item): void
    {
        if (null === $item->getChild('微信店铺')) {
            $item->addChild('微信店铺');
        }

        $wechatStoreMenu = $item->getChild('微信店铺');
        if (null === $wechatStoreMenu) {
            return;
        }

        // 添加商品类别管理菜单
        $wechatStoreMenu->addChild('商品类别管理')
            ->setUri($this->linkGenerator->getCurdListPage(Category::class))
            ->setAttribute('icon', 'fas fa-list')
        ;

        // 添加商品管理菜单
        $wechatStoreMenu->addChild('商品管理')
            ->setUri($this->linkGenerator->getCurdListPage(Product::class))
            ->setAttribute('icon', 'fas fa-box')
        ;

        // 添加运费模板管理菜单
        $wechatStoreMenu->addChild('运费模板管理')
            ->setUri($this->linkGenerator->getCurdListPage(FreightTemplate::class))
            ->setAttribute('icon', 'fas fa-shipping-fast')
        ;

        // 添加资质形象管理菜单
        $wechatStoreMenu->addChild('资质形象管理')
            ->setUri($this->linkGenerator->getCurdListPage(QualificationImage::class))
            ->setAttribute('icon', 'fas fa-certificate')
        ;

        // 添加服务器消息管理菜单
        $wechatStoreMenu->addChild('服务器消息管理')
            ->setUri($this->linkGenerator->getCurdListPage(ServerMessage::class))
            ->setAttribute('icon', 'fas fa-envelope')
        ;
    }
}
