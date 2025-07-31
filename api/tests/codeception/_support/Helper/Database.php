<?php

declare(strict_types=1);

namespace App\Tests\codeception\_support\Helper;

use Codeception\Module;
use PDO;

class Database extends Module
{
    private const string MIGRATIONS_FOLDER = 'migrations/';

    public function clearDb(string $table): void
    {
        $pdo = $this->mySqlGetConnection();

        try {
            $pdo->query('SET FOREIGN_KEY_CHECKS = 0');
            $pdo->query(sprintf('TRUNCATE %s', $table));
        } finally {
            $pdo->query('SET FOREIGN_KEY_CHECKS = 1');
        }
    }

    public function loadSqlFile(string $file): void
    {
        $this->mysqlLoadSqlFile(codecept_data_dir(self::MIGRATIONS_FOLDER . $file));
    }

    public function mySqlGetConnection(): PDO
    {
        return new PDO(
            sprintf('%s;dbname=%s;charset=UTF8', $this->config['mysql'], $this->config['mysql_database']),
            $this->config['mysql_user'],
            $this->config['mysql_password']
        );
    }

    private function mysqlLoadSqlFile(string $path): void
    {
        $pdo = $this->mySqlGetConnection();
        $pdo->query(sprintf('%s', file_get_contents($path)));
    }
}
