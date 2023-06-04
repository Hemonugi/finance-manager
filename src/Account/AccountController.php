<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AccountController
{

    public function balance(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = new AccountDto(100000);

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}