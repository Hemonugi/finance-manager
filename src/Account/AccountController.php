<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use Hemonugi\FinanceManager\JsonResponseData;
use JsonException;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;

class AccountController
{
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
        $data = new AccountDto(1000);

        return (new JsonResponseData($data))->send($response);
    }
}
