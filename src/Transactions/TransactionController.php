<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Transactions;

use Exception;
use Hemonugi\FinanceManager\Database;
use Hemonugi\FinanceManager\JsonResponseData;
use Hemonugi\FinanceManager\Swagger\ArrayJsonResponse;
use JsonException;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;

readonly final class TransactionController
{
    public function __construct(private Database $database)
    {
    }

    #[OA\Get(path: '/api/transactions', description: 'Возвращает список транзакций пользователя')]
    #[OA\Response(response: 200, description: 'Успешный запрос', content: new ArrayJsonResponse(TransactionDto::class))]
    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws JsonException
     * @throws Exception
     */
    public function list(ResponseInterface $response): ResponseInterface
    {
        $transactionList = $this->database->queryAll('SELECT * FROM transactions');

        $transactions = array_map(
            fn(array $transaction) => TransactionDto::createFromDatabaseRow($transaction),
            $transactionList
        );

        return (new JsonResponseData($transactions))->send($response);
    }
}
