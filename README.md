# WeChat Store Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-store-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-store-bundle)  
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/wechat-store-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-store-bundle)  
[![License](https://img.shields.io/packagist/l/tourze/wechat-store-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-store-bundle)  
[![PHP Version Require](https://img.shields.io/packagist/php-v/tourze/wechat-store-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-store-bundle)  
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/wechat-store-bundle/ci.yml?branch=main&style=flat-square)](https://github.com/tourze/wechat-store-bundle/actions)  
[![Coverage Status](https://img.shields.io/codecov/c/github/tourze/wechat-store-bundle?style=flat-square)](https://codecov.io/gh/tourze/wechat-store-bundle)  
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE)

A Symfony bundle for integrating with WeChat Video Channel Store (视频号小店),  
providing APIs for product management, category synchronization, and store operations.

## Features

- Category synchronization from WeChat Store
- Product management (CRUD operations)
- Freight template management
- Qualification image management
- Server message handling and webhook support
- Automatic daily category synchronization via cron job

## Installation

### Requirements

- PHP 8.1 or higher
- Symfony 6.4 or higher
- Doctrine ORM 3.0 or higher

### Install via Composer

```bash
composer require tourze/wechat-store-bundle
```

## Configuration

Register the bundle in your `config/bundles.php`:

```php
return [
    // ...
    WechatStoreBundle\WechatStoreBundle::class => ['all' => true],
];
```

## Quick Start

### Category Synchronization

The bundle provides a command to synchronize product categories from WeChat Store:

```bash
# Manual synchronization
php bin/console wechat-store:sync-category
```

This command is also configured to run automatically every day at 01:02 AM via cron job.

## Webhook Configuration

The bundle provides a webhook endpoint for receiving WeChat Store server messages:

```text
POST /wechat-store/callback/{appId}
```

Configure this URL in your WeChat Store backend to receive real-time updates.

### Entity Management

The bundle provides the following entities:

- `Category` - Product categories
- `Product` - Store products
- `FreightTemplate` - Shipping templates
- `QualificationImage` - Qualification images for products
- `ServerMessage` - Incoming server messages

### Services

- `ProductService` - Product management operations
- `AttributeControllerLoader` - Controller attribute loading

## Commands

| Command | Description | Schedule |
|---------|-------------|-----------|
| `wechat-store:sync-category` | Synchronize product categories from WeChat Store | Daily at 01:02 AM |

## API Reference

### Routes

| Route | Method | Path | Description |
|-------|--------|------|-------------|
| `wechat-store-callback` | POST | `/wechat-store/callback/{appId}` | Webhook endpoint for WeChat Store messages |

## Advanced Usage

### Custom Product Service Extensions

You can extend the `ProductService` to add custom business logic:

```php
use WechatStoreBundle\Service\ProductService;

class CustomProductService extends ProductService
{
    public function createProductWithValidation(array $data): Product
    {
        // Add custom validation logic
        $this->validateCustomRules($data);
        
        return parent::createProduct($data);
    }
}
```

### Event Listeners

Listen to store events for custom processing:

```php
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WechatStoreBundle\Event\CategorySyncEvent;

class StoreEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CategorySyncEvent::class => 'onCategorySync',
        ];
    }
    
    public function onCategorySync(CategorySyncEvent $event): void
    {
        // Custom logic after category synchronization
    }
}
```

## Security

### Input Validation

All incoming webhook data is validated against WeChat Store message format.  
Custom validation can be added through event subscribers.

### Access Control

Configure proper access control for webhook endpoints in your security configuration:

```yaml
# config/packages/security.yaml
security:
    access_control:
        - { path: ^/wechat-store/callback, roles: PUBLIC_ACCESS }
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Documentation

- [WeChat Video Channel Shop](https://channels.weixin.qq.com/shop)
- [WeChat Channels API - Get Access Token](https://developers.weixin.qq.com/doc/channels/API/basics/getaccesstoken.html)  
- [WeChat Store API - Get Stable Access Token](https://developers.weixin.qq.com/doc/store/API/basics/getStableAccessToken.html)
