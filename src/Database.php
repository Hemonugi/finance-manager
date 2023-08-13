<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager;

use PDO;

readonly final class Database
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @param string $query
     * @param string[]|int[]|float[] $params
     * @return string[][]
     */
    public function queryAll(string $query, array $params = []): array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     * @param string[]|int[]|float[] $params
     * @return array<string, string>|null
     */
    public function queryOne(string $query, array $params = []): ?array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result === false || !is_array($result)) {
            return null;
        }

        return $result;
    }

    /**
     * @param string $query
     * @param string[]|int[]|float[] $params
     * @return string|null
     */
    public function queryScalar(string $query, array $params = []): ?string
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        /** @var string|false $result */
        $result = $statement->fetch(PDO::FETCH_COLUMN);

        return $result !== false ? $result : null;
    }

    /**
     * @param string $table
     * @param array<string, mixed> $column
     * @return string|null
     */
    public function insertRow(string $table, array $column = []): ?string
    {
        $placeholders = array_fill(0, count($column), '?');
        $placeholderString = implode(', ', $placeholders);
        $query = sprintf(
            "INSERT INTO $table (%s) VALUES (%s)",
            implode(", ", array_keys($column)),
            $placeholderString,
        );

        $statement = $this->pdo->prepare($query);
        $statement->execute(array_values($column));
        $lastInsertId = $this->pdo->lastInsertId();
        return $lastInsertId !== false ? $lastInsertId : null;
    }
}
