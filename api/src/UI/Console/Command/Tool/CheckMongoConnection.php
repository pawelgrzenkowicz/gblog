<?php

declare(strict_types=1);

namespace App\UI\Console\Command\Tool;

use App\Application\Application;
use App\Infrastructure\Symfony\Console\Command;
use MongoDB\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:tool-check-mongo-connection',
    description: 'Check connection to mongoDB'
)]
final class CheckMongoConnection extends Command
{
    public function __construct(Application $application)
    {
        parent::__construct($application);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $this->application->execute(
//            new CreateTest(
//                uniqid(),
//                random_int(1, 100)
//            ),
//        );

        $uri = 'mongodb://server394072_zmaczowani:Tester123!@mongodb.server394072.nazwa.pl:4019/?authSource=admin';
        $uri = 'mongodb://server394072_zmaczowani:Tester123%21@mongodb.server394072.nazwa.pl:4019/?authSource=admin';

        $databaseName = 'server394072_zmaczowani';

        try {
            $client = new Client($uri);
//            $database = $client->selectDatabase($databaseName);
//            $collections = $database->listCollections();

//            dump($client);
            $database = $client->selectDatabase($databaseName);

            dump($database->listCollections());

            exit;
            $output->writeln("Połączono z bazą: $databaseName");
//            foreach ($collections as $collection) {
//                $output->writeln(' - ' . $collection->getName());
//            }

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln('<error>Błąd połączenia: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        $output->writeln([
            '<bg=green;>                    </>',
            '<bg=green;fg=black>    CONNECTED    </>',
            '<bg=green;>                    </>',
            ' '
        ]);

        return Command::SUCCESS;
    }
}
