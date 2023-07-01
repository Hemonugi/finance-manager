<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use Hemonugi\FinanceManager\JsonResponseData;
use JsonException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AccountController
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws JsonException
     */
    public function balance(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = new AccountDto(1000);

        return (new JsonResponseData($data))->send($response);
    }
}
