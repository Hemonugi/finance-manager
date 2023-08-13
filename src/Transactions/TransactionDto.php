<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Transactions;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use JsonSerializable;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Transaction')]
readonly class TransactionDto implements JsonSerializable
{
    public function __construct(
        #[OA\Property]
        public int $id,
        #[OA\Property]
        public string $description,
        #[OA\Property]
        public float $value,
        #[OA\Property(type: 'string', format: 'date-time')]
        public DateTimeInterface $createdAt,
        #[OA\Property(type: 'string', format: 'date-time')]
        public DateTimeInterface $updatedAt,
    ) {
    }

    /**
     * @param string[] $data
     * @return self
     * @throws Exception
     */
    public static function createFromDatabaseRow(array $data): self
    {
        return new self(
            (int)$data['id'],
            $data['description'],
            (float)$data['value'],
            new DateTimeImmutable($data['created_at']),
            new DateTimeImmutable($data['updated_at']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'value' => $this->value,
            'createdAt' => $this->createdAt->format(DATE_RFC3339),
            'updatedAt' => $this->updatedAt->format(DATE_RFC3339),
        ];
    }
}
