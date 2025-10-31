<?php

declare(strict_types=1);

namespace WechatStoreBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatStoreBundle\Entity\Product;

#[When(env: 'test')]
#[When(env: 'dev')]
class ProductFixtures extends Fixture implements FixtureGroupInterface
{
    public const PRODUCT_REFERENCE_PREFIX = 'wechat-store-product-';

    public static function getGroups(): array
    {
        return ['wechat-store'];
    }

    public function load(ObjectManager $manager): void
    {
        $categories = ['电子产品', '服装', '食品', '图书', '家居'];
        $names = [
            '智能手机',
            '笔记本电脑',
            '无线耳机',
            '运动T恤',
            '牛仔裤',
            '有机苹果',
            '纯牛奶',
            'PHP编程书籍',
            '科幻小说',
            '咖啡机',
        ];

        for ($i = 1; $i <= 20; ++$i) {
            $product = new Product();
            $product->setName($names[($i - 1) % count($names)] . ' ' . $i);
            $product->setDescription('这是商品 ' . $i . ' 的详细描述');
            $product->setPrice((string) (100 * $i)); // 价格从100分开始递增
            $product->setCategory($categories[($i - 1) % count($categories)]);
            $product->setStock(100 + $i * 10);
            $product->setStatus($i % 3 !== 0); // 每3个有一个下架

            $manager->persist($product);
            $this->addReference(self::PRODUCT_REFERENCE_PREFIX . $i, $product);
        }

        $manager->flush();
    }
}
