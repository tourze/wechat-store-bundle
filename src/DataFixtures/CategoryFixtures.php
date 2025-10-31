<?php

declare(strict_types=1);

namespace WechatStoreBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatStoreBundle\Entity\Category;

#[When(env: 'test')]
#[When(env: 'dev')]
class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public const CATEGORY_REFERENCE_PREFIX = 'wechat-store-category-';

    public static function getGroups(): array
    {
        return ['wechat-store'];
    }

    public function load(ObjectManager $manager): void
    {
        // 顶级分类
        $categories = [
            ['name' => '电子产品', 'description' => '手机、电脑、数码等电子产品', 'sort' => 1],
            ['name' => '服装鞋包', 'description' => '男装、女装、鞋子、箱包等', 'sort' => 2],
            ['name' => '食品生鲜', 'description' => '水果、蔬菜、肉类、零食等', 'sort' => 3],
            ['name' => '家居生活', 'description' => '家具、家纺、厨具等家居用品', 'sort' => 4],
            ['name' => '图书音像', 'description' => '图书、电子书、音乐、影视等', 'sort' => 5],
        ];

        $parentCategories = [];
        foreach ($categories as $index => $data) {
            $category = new Category();
            $category->setName($data['name']);
            $category->setDescription($data['description']);
            $category->setSort($data['sort']);
            $category->setStatus(true);
            $manager->persist($category);
            $this->addReference(self::CATEGORY_REFERENCE_PREFIX . ($index + 1), $category);
            $parentCategories[] = $category;
        }

        $manager->flush();

        // 子分类（依赖父级分类的ID）
        $subCategories = [
            ['name' => '手机通讯', 'parentIndex' => 0, 'sort' => 1],
            ['name' => '电脑平板', 'parentIndex' => 0, 'sort' => 2],
            ['name' => '男装', 'parentIndex' => 1, 'sort' => 1],
            ['name' => '女装', 'parentIndex' => 1, 'sort' => 2],
            ['name' => '水果蔬菜', 'parentIndex' => 2, 'sort' => 1],
        ];

        foreach ($subCategories as $index => $data) {
            $category = new Category();
            $category->setName($data['name']);
            $category->setParentId((string) $parentCategories[$data['parentIndex']]->getId());
            $category->setSort($data['sort']);
            $category->setStatus(true);
            $manager->persist($category);
            $this->addReference(self::CATEGORY_REFERENCE_PREFIX . (count($categories) + $index + 1), $category);
        }

        $manager->flush();
    }
}
