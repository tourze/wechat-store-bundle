<?php

declare(strict_types=1);

namespace WechatStoreBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatStoreBundle\Entity\ServerMessage;

#[When(env: 'test')]
#[When(env: 'dev')]
class ServerMessageFixtures extends Fixture implements FixtureGroupInterface
{
    public const SERVER_MESSAGE_REFERENCE_PREFIX = 'wechat-store-server-message-';

    public static function getGroups(): array
    {
        return ['wechat-store'];
    }

    public function load(ObjectManager $manager): void
    {
        $types = ['text', 'image', 'voice', 'video', 'link'];

        for ($i = 1; $i <= 15; ++$i) {
            $serverMessage = new ServerMessage();
            $typeIndex = ($i - 1) % count($types);
            $serverMessage->setType($types[$typeIndex]);
            $serverMessage->setContent('测试服务器消息内容 ' . $i);

            // 为图片、语音、视频类型设置媒体字段
            if (in_array($types[$typeIndex], ['image', 'voice', 'video'], true)) {
                $serverMessage->setMediaUrl('https://images.unsplash.com/photo-1599507593548-1d877d4dceb2?w=800&h=450&fit=crop&id=' . $i);
                $serverMessage->setMediaId('media_' . $types[$typeIndex] . '_' . $i);
                $serverMessage->setMediaMd5(md5('media_' . $types[$typeIndex] . '_' . $i));
            }

            $manager->persist($serverMessage);
            $this->addReference(self::SERVER_MESSAGE_REFERENCE_PREFIX . $i, $serverMessage);
        }

        $manager->flush();
    }
}
