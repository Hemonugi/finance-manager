<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Transactions;

use Exception;
use Hemonugi\FinanceManager\Database;
use Hemonugi\FinanceManager\JsonResponseData;
use Hemonugi\FinanceManager\RequestParams;
use Hemonugi\FinanceManager\Swagger\ArrayJsonResponse;
use Hemonugi\FinanceManager\Swagger\JsonResponse;
use JsonException;
use OpenApi\Attributes as OA;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

readonly final class TransactionController
{
    public function __construct(private Database $database)
    {
    }

    #[OA\Get('/api/transactions', description: 'Возвращает список транзакций пользователя', tags: ['transactions'])]
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

    #[OA\Post('/api/transactions/add/', description: 'Добавляет новую транзакцию', tags: ['transactions'])]
    #[OA\Response(response: 200, description: 'Успешный запрос', content: new JsonResponse(TransactionDto::class))]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ['description', 'value'],
                    properties: [
                        new OA\Property(
                            property: 'description',
                            description: 'Крактое описание транзакции',
                            type: 'string',
                        ),
                        new OA\Property(property: 'value', description: 'Сумма транзакции', type: 'number'),
                    ]
                )
            ),
        ],
    )]
    /**
     * Добавляет новую транзакцию в базу
     *
     * @throws JsonException
     * @throws Exception
     */
    public function add(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = new RequestParams($request);

        if (!$params->has('description', 'value')) {
            return (new JsonResponseData())
                ->setSuccess(false)
                ->setMessage('Некорректный запрос')
                ->send($response);
        }

        $id = $this->database->insertRow(
            'transactions',
            [
                'description' => $params->get('description'),
                'value' => $params->get('value'),
            ]
        );

        if ($id === null) {
            return (new JsonResponseData())
                ->setSuccess(false)
                ->setMessage('Произошла ошибка при добавлении транзакции')
                ->send($response);
        }

        $transaction = $this->database->queryOne('SELECT * FROM transactions WHERE id = ?', [(int)$id]);
        if ($transaction === null) {
            return (new JsonResponseData())
                ->setSuccess(false)
                ->setMessage('Произошла ошибка при добавлении транзакции')
                ->send($response);
        }

        $transactionDto = TransactionDto::createFromDatabaseRow($transaction);

        return (new JsonResponseData($transactionDto))->send($response);
    }
}
