<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Swagger;

use Exception;
use OpenApi\Generator;
use Psr\Http\Message\ResponseInterface;
use OpenApi\Attributes as OA;

#[OA\Info(version: "0.1", title: "Finance manager API")]
class SwaggerController
{
    /**
     * Генерирует доки отдает конфиг для свагера
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @throws Exception если не удалось создать конфиг
     */
    public function config(ResponseInterface $response): ResponseInterface
    {
        $openapi = Generator::scan([__DIR__ . '/../']);
        if ($openapi === null) {
            throw new Exception('OpenApi spec can\'t be generated');
        }

        $response->getBody()->write($openapi->toYaml());

        return $response->withHeader('Content-Type', 'application/x-yaml');
    }

    /**
     * Выводит документацию свагера
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function view(ResponseInterface $response): ResponseInterface
    {
        $viewFile = file_get_contents(__DIR__ . '/view.html');
        $response->getBody()->write($viewFile !== false ? $viewFile : '');

        return $response;
    }
}
