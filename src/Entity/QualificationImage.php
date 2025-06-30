<?php

namespace WechatStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\QualificationImageRepository;

#[ORM\Entity(repositoryClass: QualificationImageRepository::class)]
#[ORM\Table(name: 'wechat_store_qualification_image', options: ['comment' => '微信店铺资质形象'])]
class QualificationImage implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
