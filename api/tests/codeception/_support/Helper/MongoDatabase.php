<?php

declare(strict_types=1);

namespace App\Tests\codeception\_support\Helper;

use Codeception\Module;
use MongoDB\Client;

class MongoDatabase extends Module
{
    private const string MIGRATIONS_FOLDER = 'migrations/';

    public function dropDatabase(string $collection): void
    {
        $client = $this->getMongoConnection();

        $client->selectCollection($this->selectDatabase(), $collection)->drop();
    }

    public function deleteRecordsInDatabase(string $collection): void
    {
        $client = $this->getMongoConnection();

        $client->selectCollection($this->selectDatabase(), $collection)->deleteMany([]);
    }

    public function getMongoConnection(): Client
    {
        return new Client($this->config['database_url'], [
            'username' => $this->config['user'],
            'password' => $this->config['password'],
        ]);
    }

    public function insertManyDocuments(string $collection, array $documents): void
    {
        $this->getMongoConnection()->selectCollection($this->selectDatabase(), $collection)->insertMany($documents);
    }

    public function insertFromJsonFile(string $collection, string $path): void
    {
        $this->insertManyDocuments(
            $collection,
            json_decode(file_get_contents(codecept_data_dir(sprintf('%s%s', self::MIGRATIONS_FOLDER, $path))), true)
        );
    }

    private function selectDatabase(): string
    {
        return $this->config['database'];
    }
}
