<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Swagger;

use OpenApi\Attributes as OA;

/**
 * Описание json-ответа, который в data содержит объект
 */
class JsonResponse extends OA\JsonContent
{
    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        parent::__construct(properties: [
            new OA\Property(property: 'success', description: 'Успешность операции', type: 'boolean'),
            new OA\Property(
                property: 'message',
                description: 'Сообщение которое нужно вывести пользователю',
                type: 'string',
                nullable: true
            ),
            $this->getDataProperty($className),
        ]);
    }

    /**
     * Возвращает описание поля data для ответа
     *
     * @param string $className
     * @return OA\Property
     */
    protected function getDataProperty(string $className): OA\Property
    {
        return new OA\Property(property: 'data', ref: $this->getSchema($className), nullable: true);
    }

    /**
     * @param string $className
     * @return string
     */
    protected function getSchema(string $className): string
    {
        $className = basename(str_replace('\\', DIRECTORY_SEPARATOR, $className));

        return '#/components/schemas/' . $className;
    }
}
