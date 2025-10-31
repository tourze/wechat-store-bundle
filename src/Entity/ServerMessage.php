<?php

declare(strict_types=1);

namespace WechatStoreBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatStoreBundle\Repository\ServerMessageRepository;

#[ORM\Entity(repositoryClass: ServerMessageRepository::class)]
#[ORM\Table(name: 'wechat_store_server_message', options: ['comment' => '微信商店服务器消息'])]
class ServerMessage implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    #[ORM\Column(type: Types::STRING, length: 50, options: ['comment' => '消息类型'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private string $type = '';

    #[ORM\Column(type: Types::TEXT, options: ['comment' => '消息内容'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 65535)]
    private string $content = '';

    #[ORM\Column(type: Types::STRING, length: 500, nullable: true, options: ['comment' => '媒体URL'])]
    #[Assert\Length(max: 500)]
    #[Assert\Url]
    private ?string $mediaUrl = null;

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: ['comment' => '媒体ID'])]
    #[Assert\Length(max: 100)]
    private ?string $mediaId = null;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: true, options: ['comment' => '媒体MD5'])]
    #[Assert\Length(max: 32)]
    #[Assert\Regex(pattern: '/^[a-f0-9]{32}$/')]
    private ?string $mediaMd5 = null;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type ?? '';
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content ?? '';
    }

    public function getMediaUrl(): ?string
    {
        return $this->mediaUrl;
    }

    public function setMediaUrl(?string $mediaUrl): void
    {
        $this->mediaUrl = $mediaUrl;
    }

    public function getMediaId(): ?string
    {
        return $this->mediaId;
    }

    public function setMediaId(?string $mediaId): void
    {
        $this->mediaId = $mediaId;
    }

    public function getMediaMd5(): ?string
    {
        return $this->mediaMd5;
    }

    public function setMediaMd5(?string $mediaMd5): void
    {
        $this->mediaMd5 = $mediaMd5;
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
