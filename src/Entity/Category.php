<?php

declare(strict_types=1);

namespace WechatStoreBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\CategoryRepository;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'wechat_store_category', options: ['comment' => '微信商店类别'])]
class Category implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    #[ORM\Column(type: Types::STRING, length: 100, options: ['comment' => '分类名称'])]
    #[Assert\NotBlank(message: '分类名称不能为空')]
    #[Assert\Length(max: 100, maxMessage: '分类名称不能超过{{ limit }}个字符')]
    private string $name = '';

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => '分类描述'])]
    #[Assert\Length(max: 5000, maxMessage: '分类描述不能超过{{ limit }}个字符')]
    private ?string $description = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true, options: ['comment' => '父级分类ID'])]
    #[Assert\Type(type: 'numeric', message: '父级分类ID必须是数字')]
    private ?string $parentId = null;

    #[ORM\Column(type: Types::INTEGER, options: ['comment' => '排序', 'default' => 0])]
    #[Assert\GreaterThanOrEqual(value: 0, message: '排序不能为负数')]
    private int $sort = 0;

    #[ORM\Column(type: Types::BOOLEAN, options: ['comment' => '是否启用'])]
    #[Assert\NotNull(message: '状态不能为空')]
    private bool $status = true;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function setParentId(?string $parentId): void
    {
        $this->parentId = $parentId;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
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
