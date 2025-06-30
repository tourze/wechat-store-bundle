<?php

namespace WechatStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\ServerMessageRepository;

#[ORM\Entity(repositoryClass: ServerMessageRepository::class)]
#[ORM\Table(name: 'wechat_store_server_message', options: ['comment' => '微信商店服务器消息'])]
class ServerMessage implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
