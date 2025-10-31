# WechatStoreBundle Tests

本目录包含 WechatStoreBundle 的所有测试用例。

## 测试结构

测试分为两个主要部分：

- Unit: 单元测试，专注于测试组件的隔离行为
- Integration: 集成测试，专注于测试组件在 Symfony 环境中的协同工作

## 运行测试

从项目根目录运行所有测试：

```bash
./vendor/bin/phpunit packages/wechat-store-bundle/tests
```

运行单元测试：

```bash
./vendor/bin/phpunit packages/wechat-store-bundle/tests/Unit
```

运行集成测试：

```bash
./vendor/bin/phpunit packages/wechat-store-bundle/tests/Integration
```

## 测试原则

1. 每个测试方法只测试一个行为或场景
2. 测试用例覆盖正常流程和异常/边界情况
3. 实体测试使用 `AbstractEntityTest` 基类减少重复
4. 命名遵循 `test<方法名>_<场景描述>` 格式

## 注意事项

- 部分测试被标记为跳过，因为它们需要完整的 Symfony 环境
- 所有测试都不依赖第三方扩展或修改 phpunit 配置
- 测试用例设计考虑了包的未来发展，为新功能添加做好准备 