<?php

namespace app\models;

use Flight;
use PDO;
use PDOException;

class Connection
{
    private  $DBH;

    public function __construct(PDO $dbh = null)
    {
        $this->DBH = $dbh ?? Flight::db();
    }

    /**
     * Fetch data from the database using a query without parameters.
     *
     * @param string $query
     * @return array|null
     */
    public function fetchQuery(string $query): ?array
    {
        try {
            $stmt = $this->DBH->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error executing fetchQuery: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Fetch data from the database using a query with parameters.
     *
     * @param string $query
     * @param array $params
     * @return array|null
     */
    public function fetchQueryWithParams(string $query, array $params): ?array
    {
        try {
            $stmt = $this->DBH->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error executing fetchQueryWithParams: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Execute an update query (INSERT, UPDATE, DELETE) without parameters.
     *
     * @param string $query
     * @return int|null Number of rows affected or null on error
     */
    public function updateQuery(string $query): ?int
    {
        try {
            $stmt = $this->DBH->prepare($query);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->logError("Error executing updateQuery: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Execute an update query (INSERT, UPDATE, DELETE) with parameters.
     *
     * @param string $query
     * @param array $parameters
     * @return int|null Number of rows affected or null on error
     */
    public function updateQueryWithParameters(string $query, array $parameters): ?int
    {
        try {
            $stmt = $this->DBH->prepare($query);
            $stmt->execute($parameters);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->logError("Error executing updateQueryWithParameters: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Log error messages to a file or logging system.
     *
     * @param string $message
     * @return void
     */
    private function logError(string $message): void
    {
        // Log the error to a file, monitoring system, or standard error output
        error_log($message); // Default PHP error log
    }

    /**
     * Close the database connection when the object is destroyed.
     */
    public function __destruct()
    {
        $this->DBH = null;
    }
}
