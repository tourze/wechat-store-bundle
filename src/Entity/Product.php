<?php

declare(strict_types=1);

namespace WechatStoreBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\ProductRepository;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'wechat_store_product', options: ['comment' => '微信商店产品'])]
class Product implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    #[ORM\Column(type: Types::STRING, length: 100, options: ['comment' => '商品名称'])]
    #[Assert\NotBlank(message: '商品名称不能为空')]
    #[Assert\Length(max: 100, maxMessage: '商品名称不能超过{{ limit }}个字符')]
    private string $name = '';

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => '商品描述'])]
    #[Assert\Length(max: 5000, maxMessage: '商品描述不能超过{{ limit }}个字符')]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: ['comment' => '价格（分）'])]
    #[Assert\NotBlank(message: '价格不能为空')]
    #[Assert\GreaterThanOrEqual(value: 0, message: '价格不能为负数')]
    private string $price = '0.00';

    #[ORM\Column(type: Types::STRING, length: 50, nullable: true, options: ['comment' => '分类'])]
    #[Assert\Length(max: 50, maxMessage: '分类不能超过{{ limit }}个字符')]
    private ?string $category = null;

    #[ORM\Column(type: Types::INTEGER, options: ['comment' => '库存数量', 'default' => 0])]
    #[Assert\PositiveOrZero(message: '库存数量不能为负数')]
    private int $stock = 0;

    #[ORM\Column(type: Types::BOOLEAN, options: ['comment' => '是否上架'])]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(?string $price): void
    {
        $this->price = $price ?? '0.00';
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
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
