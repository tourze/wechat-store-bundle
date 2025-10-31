<?php

declare(strict_types=1);

namespace WechatStoreBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatStoreBundle\Entity\QualificationImage;

#[When(env: 'test')]
#[When(env: 'dev')]
class QualificationImageFixtures extends Fixture implements FixtureGroupInterface
{
    public const QUALIFICATION_IMAGE_REFERENCE_PREFIX = 'wechat-store-qualification-image-';

    public static function getGroups(): array
    {
        return ['wechat-store'];
    }

    public function load(ObjectManager $manager): void
    {
        $qualifications = [
            [
                'title' => '营业执照',
                'imagePath' => '/uploads/qualifications/business_license.jpg',
                'sortOrder' => 1,
                'status' => true,
            ],
            [
                'title' => '食品经营许可证',
                'imagePath' => '/uploads/qualifications/food_license.jpg',
                'sortOrder' => 2,
                'status' => true,
            ],
            [
                'title' => '卫生许可证',
                'imagePath' => '/uploads/qualifications/health_license.jpg',
                'sortOrder' => 3,
                'status' => true,
            ],
            [
                'title' => '品牌授权书',
                'imagePath' => '/uploads/qualifications/brand_auth.jpg',
                'sortOrder' => 4,
                'status' => true,
            ],
            [
                'title' => '质量检测报告',
                'imagePath' => '/uploads/qualifications/quality_report.jpg',
                'sortOrder' => 5,
                'status' => true,
            ],
            [
                'title' => '商标注册证',
                'imagePath' => '/uploads/qualifications/trademark.jpg',
                'sortOrder' => 6,
                'status' => true,
            ],
            [
                'title' => '产品合格证',
                'imagePath' => '/uploads/qualifications/product_cert.jpg',
                'sortOrder' => 7,
                'status' => true,
            ],
            [
                'title' => '荣誉证书',
                'imagePath' => '/uploads/qualifications/honor_cert.jpg',
                'sortOrder' => 8,
                'status' => false,
            ],
            [
                'title' => '门店实景图',
                'imagePath' => '/uploads/qualifications/store_photo.jpg',
                'sortOrder' => 9,
                'status' => true,
            ],
            [
                'title' => '仓库实景图',
                'imagePath' => '/uploads/qualifications/warehouse_photo.jpg',
                'sortOrder' => 10,
                'status' => true,
            ],
        ];

        for ($i = 0; $i < 10; ++$i) {
            $qualificationImage = new QualificationImage();
            $qualificationImage->setTitle($qualifications[$i]['title']);
            $qualificationImage->setImagePath($qualifications[$i]['imagePath']);
            $qualificationImage->setSortOrder($qualifications[$i]['sortOrder']);
            $qualificationImage->setStatus($qualifications[$i]['status']);

            $manager->persist($qualificationImage);
            $this->addReference(
                self::QUALIFICATION_IMAGE_REFERENCE_PREFIX . ($i + 1),
                $qualificationImage
            );
        }

        $manager->flush();
    }
}
