<?php

namespace WechatStoreBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;

#[AsCronTask(expression: '2 1 * * *')]
#[AsCommand(name: self::NAME, description: '同步类目到本地')]
class SyncCategoryCommand extends Command
{
    public const NAME = 'wechat-store:sync-category';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('TEST');

        return Command::SUCCESS;
    }
}
