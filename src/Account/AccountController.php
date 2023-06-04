<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use Hemonugi\FinanceManager\JsonResponseData;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AccountController
{

    public function balance(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = new AccountDto(1000);

        return (new JsonResponseData($data))->send($response);
    }
}