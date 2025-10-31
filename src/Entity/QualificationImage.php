<?php

declare(strict_types=1);

namespace WechatStoreBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\QualificationImageRepository;

#[ORM\Entity(repositoryClass: QualificationImageRepository::class)]
#[ORM\Table(name: 'wechat_store_qualification_image', options: ['comment' => '微信店铺资质形象'])]
class QualificationImage implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    #[ORM\Column(type: Types::STRING, length: 200, options: ['comment' => '标题'])]
    #[Assert\NotBlank(message: '标题不能为空')]
    #[Assert\Length(max: 200, maxMessage: '标题不能超过{{ limit }}个字符')]
    private string $title = '';

    #[ORM\Column(type: Types::STRING, length: 500, options: ['comment' => '图片路径'])]
    #[Assert\NotBlank(message: '图片路径不能为空')]
    #[Assert\Length(max: 500, maxMessage: '图片路径不能超过{{ limit }}个字符')]
    private string $imagePath = '';

    #[ORM\Column(type: Types::INTEGER, options: ['comment' => '排序', 'default' => 0])]
    #[Assert\GreaterThanOrEqual(value: 0, message: '排序不能为负数')]
    private int $sortOrder = 0;

    #[ORM\Column(type: Types::BOOLEAN, options: ['comment' => '是否启用'])]
    #[Assert\NotNull(message: '状态不能为空')]
    private bool $status = true;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title ?? '';
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath ?? '';
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
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
        return $this->title !== '' ? $this->title : (string) $this->getId();
    }
}
