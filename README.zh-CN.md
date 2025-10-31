# WeChat Store Bundle - 微信视频号小店扩展包

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-store-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-store-bundle)  
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/wechat-store-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-store-bundle)  
[![License](https://img.shields.io/packagist/l/tourze/wechat-store-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-store-bundle)  
[![PHP Version Require](https://img.shields.io/packagist/php-v/tourze/wechat-store-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-store-bundle)  
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/wechat-store-bundle/ci.yml?branch=main&style=flat-square)](https://github.com/tourze/wechat-store-bundle/actions)  
[![Coverage Status](https://img.shields.io/codecov/c/github/tourze/wechat-store-bundle?style=flat-square)](https://codecov.io/gh/tourze/wechat-store-bundle)  
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE)

一个用于集成微信视频号小店的 Symfony 扩展包，提供商品管理、类目同步和店铺操作等功能的 API。

## 功能特性

- 从微信小店同步商品类目
- 商品管理（增删改查操作）
- 运费模板管理
- 资质图片管理
- 服务器消息处理和 webhook支持
- 通过定时任务自动每日同步类目

## 安装

### 系统要求

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- Doctrine ORM 3.0 或更高版本

### 通过 Composer 安装

```bash
composer require tourze/wechat-store-bundle
```

## 配置

在 `config/bundles.php` 中注册扩展包：

```php
return [
    // ...
    WechatStoreBundle\WechatStoreBundle::class => ['all' => true],
];
```

## 快速开始

### 类目同步

该扩展包提供了从微信小店同步商品类目的命令：

```bash
# 手动同步
php bin/console wechat-store:sync-category
```

该命令也配置为每天凌晨1:02自动运行。

## Webhook 配置

该扩展包提供了一个webhook端点用于接收微信小店服务器消息：

```text
POST /wechat-store/callback/{appId}
```

在您的微信小店后台配置此URL以接收实时更新。

### 实体管理

该扩展包提供以下实体：

- `Category` - 商品类目
- `Product` - 店铺商品
- `FreightTemplate` - 运费模板
- `QualificationImage` - 商品资质图片
- `ServerMessage` - 传入的服务器消息

### 服务

- `ProductService` - 商品管理操作
- `AttributeControllerLoader` - 控制器属性加载

## 命令

| 命令 | 描述 | 调度 |
|---------|-------------|-----------|
| `wechat-store:sync-category` | 从微信小店同步商品类目 | 每天凌晨1:02 |

## API 参考

### 路由

| 路由 | 方法 | 路径 | 描述 |
|-------|--------|------|-------------|
| `wechat-store-callback` | POST | `/wechat-store/callback/{appId}` | 微信小店消息Webhook端点 |

## 高级用法

### 自定义商品服务扩展

您可以扩展 `ProductService` 来添加自定义业务逻辑：

```php
use WechatStoreBundle\Service\ProductService;

class CustomProductService extends ProductService
{
    public function createProductWithValidation(array $data): Product
    {
        // 添加自定义验证逻辑
        $this->validateCustomRules($data);
        
        return parent::createProduct($data);
    }
}
```

### 事件监听器

监听店铺事件进行自定义处理：

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
        // 类目同步后的自定义逻辑
    }
}
```

## 安全

### 输入验证

所有传入的webhook数据都会根据微信小店消息格式进行验证。  
可以通过事件订阅器添加自定义验证。

### 访问控制

在安全配置中为webhook端点配置适当的访问控制：

```yaml
# config/packages/security.yaml
security:
    access_control:
        - { path: ^/wechat-store/callback, roles: PUBLIC_ACCESS }
```

## 贡献

欢迎贡献！请随时提交 Pull Request。

## 许可证

MIT 许可证 (MIT)。详情请参阅[许可证文件](LICENSE)。

## 参考文档

- [微信视频号小店](https://channels.weixin.qq.com/shop)
- [微信小店API - 获取Access Token](https://developers.weixin.qq.com/doc/channels/API/basics/getaccesstoken.html)
- [微信小店API - 获取稳定Access Token](https://developers.weixin.qq.com/doc/store/API/basics/getStableAccessToken.html)
