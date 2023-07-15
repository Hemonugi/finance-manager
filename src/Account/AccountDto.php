<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use JsonSerializable;

readonly final class AccountDto implements JsonSerializable
{
    public function __construct(public float $value)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
        ];
    }
}
