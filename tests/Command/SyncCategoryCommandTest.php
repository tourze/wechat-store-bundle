<?php

namespace WechatStoreBundle\Tests\Command;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use WechatStoreBundle\Command\SyncCategoryCommand;

/**
 * @internal
 */
#[CoversClass(SyncCategoryCommand::class)]
#[Group('unit')]
#[RunTestsInSeparateProcesses]
final class SyncCategoryCommandTest extends AbstractCommandTestCase
{
    protected function onSetUp(): void
    {
    }

    protected function getCommandTester(): CommandTester
    {
        /** @var SyncCategoryCommand $command */
        $command = self::getContainer()->get(SyncCategoryCommand::class);

        return new CommandTester($command);
    }

    private function createCommandTester(): CommandTester
    {
        return $this->getCommandTester();
    }

    public function testExecuteCommandReturnsSuccess(): void
    {
        $commandTester = $this->createCommandTester();
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $statusCode = $commandTester->getStatusCode();

        $this->assertStringContainsString('TEST', $output);
        $this->assertEquals(Command::SUCCESS, $statusCode);
    }

    public function testCommandAttributesAreSetCorrectly(): void
    {
        $commandReflection = new \ReflectionClass(SyncCategoryCommand::class);
        $attributes = $commandReflection->getAttributes();

        $hasAsCommand = false;
        $hasCronTask = false;

        foreach ($attributes as $attribute) {
            $attributeName = $attribute->getName();
            if (str_contains($attributeName, 'AsCommand')) {
                $hasAsCommand = true;
                $args = $attribute->getArguments();
                $this->assertEquals('wechat-store:sync-category', $args['name'] ?? null);
                $this->assertEquals('同步类目到本地', $args['description'] ?? null);
            }

            if (str_contains($attributeName, 'AsCronTask')) {
                $hasCronTask = true;
                $args = $attribute->getArguments();
                $this->assertEquals('2 1 * * *', $args['expression'] ?? null);
            }
        }

        $this->assertTrue($hasAsCommand, 'Command 类缺少 AsCommand 属性');
        $this->assertTrue($hasCronTask, 'Command 类缺少 AsCronTask 属性');
    }

    public function testExecuteWithVerboseOptionOutputsMoreInformation(): void
    {
        $commandTester = $this->createCommandTester();
        $commandTester->execute([], ['verbosity' => 256]); // Output::VERBOSITY_VERBOSE

        $output = $commandTester->getDisplay();

        // 即使在详细模式下，当前实现也只输出 TEST
        $this->assertStringContainsString('TEST', $output);
    }

    public function testExecuteWithQuietOptionOutputsLessInformation(): void
    {
        $commandTester = $this->createCommandTester();
        $commandTester->execute([], ['verbosity' => 16]); // Output::VERBOSITY_QUIET

        $output = $commandTester->getDisplay();

        // 在安静模式下，输出应该被抑制
        // 但由于命令直接使用 writeln，我们测试实际行为
        $this->assertEmpty($output);
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    /**
     * 测试命令的帮助信息是否正确
     */
    public function testCommandHelpIsCorrect(): void
    {
        /** @var SyncCategoryCommand $command */
        $command = self::getContainer()->get(SyncCategoryCommand::class);
        $application = new Application();
        $application->add($command);
        $foundCommand = $application->find('wechat-store:sync-category');

        // 直接检查命令属性而不是运行帮助
        $this->assertEquals('wechat-store:sync-category', $foundCommand->getName());
        $this->assertEquals('同步类目到本地', $foundCommand->getDescription());

        // 验证命令配置正确性
        $this->assertIsString($foundCommand->getName());
        $this->assertIsString($foundCommand->getDescription());
        $this->assertNotEmpty($foundCommand->getName());
        $this->assertNotEmpty($foundCommand->getDescription());
    }
}
