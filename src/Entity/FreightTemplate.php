<?php

namespace WechatStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\FreightTemplateRepository;

#[ORM\Entity(repositoryClass: FreightTemplateRepository::class)]
#[ORM\Table(name: 'wechat_store_freight_template', options: ['comment' => '微信店铺运费模板'])]
class FreightTemplate implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
