<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Tests\Swagger;

use Hemonugi\FinanceManager\Swagger\JsonResponse;
use Hemonugi\FinanceManager\Transactions\TransactionDto;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

class JsonResponseTest extends TestCase
{
    /**
     * @dataProvider schemaDataProvider
     * @param string $className
     * @param string $expectedSchema
     * @return void
     */
    public function testSchema(string $className, string $expectedSchema): void
    {
        $response = new JsonResponse($className);

        $dataProperty = current(
            array_filter(
                $response->properties,
                fn($property) => $property->property === 'data',
            )
        );

        if ($dataProperty === false) {
            self::fail('Не найдено data property');
        }

        assertSame($expectedSchema, $dataProperty->ref);
    }

    /**
     * @return string[][]
     * @see testSchema
     */
    public static function schemaDataProvider(): array
    {
        return [
            'Имя класса без неймспейса' => ['TransactionDto', '#/components/schemas/TransactionDto'],
            'Имя класс с неймспейсом' => [TransactionDto::class, '#/components/schemas/TransactionDto'],
        ];
    }
}
