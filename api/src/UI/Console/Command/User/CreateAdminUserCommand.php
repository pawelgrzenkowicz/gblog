<?php

declare(strict_types=1);

namespace App\UI\Console\Command\User;

use App\Application\User\Command\CreateUser;
use App\Domain\Shared\Enum\Role;
use App\Infrastructure\Symfony\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-admin-user',
    description: 'Create new Admin User',
)]
final class CreateAdminUserCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->application->execute(
            new CreateUser(
                'zmaczowani@zmaczowani.dev',
                'Zmaczowani',
                'Tamto123!',
                Role::SUPER_ADMIN
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
