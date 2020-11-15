<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SolveCommand extends Command
{
    protected static $defaultName = 'app:solve';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world');

        return Command::SUCCESS;
    }
}
