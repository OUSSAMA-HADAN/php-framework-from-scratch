<?php

declare(strict_types=1);

namespace Framework\Database;

use PDO;

// Manages a single shared PDO connection for the entire request lifecycle.
// Reads credentials from $_ENV (populated by .env via phpdotenv).
class Database implements DatabaseInterface
{
    // Holds the connection once created. Null until first call to getConnection().
    private ?PDO $connection = null;

    // Returns the PDO connection, creating it on the first call (lazy init).
    // Reuses the same instance on subsequent calls — no reconnecting per query.
    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $_ENV['DB_HOST'],
                $_ENV['DB_NAME']
            );

            $this->connection = new PDO(
                $dsn,
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'],
                [
                    // Throw exceptions on DB errors instead of silent failures.
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    // Return rows as associative arrays by default.
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return $this->connection;
    }
}
