<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use WechatStoreBundle\DependencyInjection\WechatStoreExtension;

/**
 * @internal
 */
#[CoversClass(WechatStoreExtension::class)]
final class WechatStoreExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
}
