<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Account;

use JsonSerializable;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Account')]
readonly final class AccountDto implements JsonSerializable
{
    public function __construct(
        #[OA\Property]
        public float $value
    ) {
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
