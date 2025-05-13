# Integration Tests

本目录包含所有的集成测试，专注于测试组件在 Symfony 环境中的协同工作。

## 运行方式

从项目根目录运行所有集成测试：

```bash
./vendor/bin/phpunit packages/wechat-store-bundle/tests/Integration
```

## 测试内核

集成测试使用自定义的 `IntegrationTestKernel` 来模拟 Symfony 应用程序环境。这个内核配置了必要的服务和 Bundle。

## 跳过的测试

许多集成测试目前被标记为跳过，因为它们需要完整的 Symfony 环境，包括数据库连接和各种服务配置。这些测试主要作为模板，演示如何在实际应用程序中测试 Bundle 的集成。 