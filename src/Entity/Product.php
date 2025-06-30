<?php

namespace WechatStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\ProductRepository;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'wechat_store_product', options: ['comment' => '微信商店产品'])]
class Product implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
