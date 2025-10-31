<?php

declare(strict_types=1);

namespace WechatStoreBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\FreightTemplateRepository;

#[ORM\Entity(repositoryClass: FreightTemplateRepository::class)]
#[ORM\Table(name: 'wechat_store_freight_template', options: ['comment' => '微信店铺运费模板'])]
class FreightTemplate implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    #[ORM\Column(type: Types::STRING, length: 100, options: ['comment' => '模板名称'])]
    #[Assert\NotBlank(message: '模板名称不能为空')]
    #[Assert\Length(max: 100, maxMessage: '模板名称不能超过{{ limit }}个字符')]
    private string $name = '';

    #[ORM\Column(type: Types::STRING, length: 20, options: ['comment' => '计费方式：weight|count|volume'])]
    #[Assert\NotBlank(message: '计费方式不能为空')]
    #[Assert\Choice(choices: ['weight', 'count', 'volume'], message: '计费方式只能是：按重量、按件数、按体积')]
    private string $type = '';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: ['comment' => '基础价格（分）'])]
    #[Assert\NotBlank(message: '价格不能为空')]
    #[Assert\GreaterThanOrEqual(value: 0, message: '价格不能为负数')]
    private string $price = '0.00';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: ['comment' => '免运费金额（分）'])]
    #[Assert\GreaterThanOrEqual(value: 0, message: '免运费金额不能为负数')]
    private string $freeAmount = '0.00';

    #[ORM\Column(type: Types::BOOLEAN, options: ['comment' => '是否启用'])]
    #[Assert\NotNull(message: '状态不能为空')]
    private bool $status = true;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name ?? '';
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type ?? '';
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(?string $price): void
    {
        $this->price = $price ?? '0.00';
    }

    public function getFreeAmount(): string
    {
        return $this->freeAmount;
    }

    public function setFreeAmount(?string $freeAmount): void
    {
        $this->freeAmount = $freeAmount ?? '0.00';
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function __toString(): string
    {
        return $this->name !== '' ? $this->name : (string) $this->getId();
    }
}
