<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use Hemonugi\FinanceManager\Database;
use Hemonugi\FinanceManager\JsonResponseData;
use Hemonugi\FinanceManager\Swagger\JsonResponse;
use JsonException;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;

readonly final class AccountController
{
    public function __construct(private Database $database)
    {
    }

    #[OA\Get(path: '/api/account', description: 'Возвращает информацию о балансе пользователя')]
    #[OA\Response(response: 200, description: 'Успешный запрос', content: new JsonResponse('AccountDto'))]
    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws JsonException
     */
    public function balance(ResponseInterface $response): ResponseInterface
    {
        $sum = (float)$this->database->queryScalar('SELECT SUM(value) FROM transactions');
        $result = new AccountDto($sum);

        return (new JsonResponseData($result))->send($response);
    }
}
