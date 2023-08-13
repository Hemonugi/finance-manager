<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Swagger;

use OpenApi\Attributes as OA;

/**
 * Описание json-ответа, который в data содержит массив
 */
class ArrayJsonResponse extends JsonResponse
{
    /**
     * @inheritDoc
     */
    protected function getDataProperty(string $className): OA\Property
    {
        return new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: $this->getSchema($className)),
            nullable: true
        );
    }
}
