<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use Hemonugi\FinanceManager\Database;
use Hemonugi\FinanceManager\JsonResponseData;
use JsonException;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;

readonly final class AccountController
{
    public function __construct(private Database $database)
    {
    }

    #[OA\Get(
        path: '/api/account',
        responses: [
            new OA\Response(response: 200, description: 'Successful response')
        ]
    )]
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
