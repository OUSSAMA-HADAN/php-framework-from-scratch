<?php

declare(strict_types=1);

namespace Framework\Database;

use PDO;

// Contract for the database connection manager.
// Any class that provides a PDO connection must implement this.
interface DatabaseInterface
{
    // Returns the active PDO connection, creating it if it doesn't exist yet.
    public function getConnection(): PDO;
}
