<?php

namespace WechatStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\CategoryRepository;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'wechat_store_category', options: ['comment' => '微信商店类别'])]
class Category implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
