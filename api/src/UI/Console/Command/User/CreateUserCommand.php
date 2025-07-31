<?php

declare(strict_types=1);

namespace App\UI\Console\Command\User;

use App\Application\User\Command\CreateUser;
use App\Domain\Shared\Enum\Role;
use App\Infrastructure\Symfony\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create new User',
)]
final class CreateUserCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setHelp('This command allow you to create new user.')

            ->addOption('email', mode: InputOption::VALUE_REQUIRED, description: 'Email')
            ->addOption('nickname', mode: InputOption::VALUE_REQUIRED, description: 'nickname')
            ->addOption('password', 'p', mode: InputOption::VALUE_REQUIRED, description: 'Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputData = $input->getOptions();

        $this->application->execute(
            new CreateUser(
                $inputData['email'],
                $inputData['nickname'],
                $inputData['password'],
                Role::FREE_USER
        ));

        $output->writeln([
            '<bg=green;>                    </>',
            '<bg=green;fg=black>    USER CREATED    </>',
            '<bg=green;>                    </>',
            ' '
        ]);

        return Command::SUCCESS;
    }
}
