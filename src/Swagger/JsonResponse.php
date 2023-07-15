<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Swagger;

use OpenApi\Attributes as OA;

/**
 * Дефолтный респонс для всех ответов с апи
 */
class JsonResponse extends OA\JsonContent
{
    /**
     * @param string $schemaClass
     */
    public function __construct(string $schemaClass)
    {
        parent::__construct(properties: [
            new OA\Property(property: 'success', description: 'Успешность операции', type: 'boolean'),
            new OA\Property(
                property: 'message',
                description: 'Сообщение которое нужно вывести пользователю',
                type: 'string',
                nullable: true
            ),
            new OA\Property(property: 'data', ref: '#/components/schemas/' . $schemaClass, nullable: true),
        ]);
    }
}
