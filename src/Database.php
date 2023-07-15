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
     * @return string[]
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
}
