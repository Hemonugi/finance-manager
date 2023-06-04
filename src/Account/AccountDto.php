<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use JsonSerializable;

readonly class AccountDto implements JsonSerializable
{
    public function __construct(public int $value)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
        ];
    }
}