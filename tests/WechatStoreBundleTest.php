<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use WechatStoreBundle\WechatStoreBundle;

/**
 * @internal
 */
#[CoversClass(WechatStoreBundle::class)]
#[RunTestsInSeparateProcesses]
final class WechatStoreBundleTest extends AbstractBundleTestCase
{
}
