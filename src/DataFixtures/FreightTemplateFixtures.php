<?php

declare(strict_types=1);

namespace WechatStoreBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatStoreBundle\Entity\FreightTemplate;

#[When(env: 'test')]
#[When(env: 'dev')]
class FreightTemplateFixtures extends Fixture implements FixtureGroupInterface
{
    public const FREIGHT_TEMPLATE_REFERENCE_PREFIX = 'wechat-store-freight-template-';

    public static function getGroups(): array
    {
        return ['wechat-store'];
    }

    public function load(ObjectManager $manager): void
    {
        $templates = [
            [
                'name' => '标准运费模板',
                'type' => 'weight',
                'price' => '500',
                'freeAmount' => '10000',
                'status' => true,
            ],
            [
                'name' => '包邮运费模板',
                'type' => 'weight',
                'price' => '0',
                'freeAmount' => '0',
                'status' => true,
            ],
            [
                'name' => '按件数计费模板',
                'type' => 'count',
                'price' => '300',
                'freeAmount' => '5000',
                'status' => true,
            ],
            [
                'name' => '体积计费模板',
                'type' => 'volume',
                'price' => '800',
                'freeAmount' => '15000',
                'status' => true,
            ],
            [
                'name' => '禁用模板',
                'type' => 'weight',
                'price' => '600',
                'freeAmount' => '8000',
                'status' => false,
            ],
        ];

        foreach ($templates as $index => $templateData) {
            $freightTemplate = new FreightTemplate();
            $freightTemplate->setName($templateData['name']);
            $freightTemplate->setType($templateData['type']);
            $freightTemplate->setPrice($templateData['price']);
            $freightTemplate->setFreeAmount($templateData['freeAmount']);
            $freightTemplate->setStatus($templateData['status']);

            $manager->persist($freightTemplate);
            $this->addReference(self::FREIGHT_TEMPLATE_REFERENCE_PREFIX . ($index + 1), $freightTemplate);
        }

        $manager->flush();
    }
}
