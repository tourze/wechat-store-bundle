# Unit Tests

本目录包含所有的单元测试，专注于测试组件的隔离行为，不依赖外部系统。

## 运行方式

从项目根目录运行所有单元测试：

```bash
./vendor/bin/phpunit packages/wechat-store-bundle/tests/Unit
```

## 测试组织

- Entity: 实体测试
- Service: 服务测试
- Command: 命令测试
- Repository: 仓库测试（部分跳过，因为需要 Doctrine） 