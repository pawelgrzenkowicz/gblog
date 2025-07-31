<?php

declare(strict_types=1);

namespace App\UI\Console\Command\Tool;

use App\Application\Test\Command\CreateTest;
use App\Infrastructure\Symfony\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:tool-check-connection',
    description: 'Check connection to MySql and create Test object.'
)]
final class CheckConnectionCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->application->execute(
            new CreateTest(
                uniqid(),
                random_int(1, 100)
            ),
        );

        $output->writeln([
            '<bg=green;>                    </>',
            '<bg=green;fg=black>    TEST CREATED    </>',
            '<bg=green;>                    </>',
            ' '
        ]);

        return Command::SUCCESS;
    }
}
