<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Tests;

use Hemonugi\FinanceManager\JsonResponseData;
use JsonException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class JsonResponseDataTest extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testResponseSuccessIsTrueByDefault(): void
    {
        $response = (new JsonResponseData())->send(new Response());

        self::assertTrue($this->getJson($response)['success']);
    }

    /**
     * @throws JsonException
     */
    public function testResponseDataCanBeSetFromConstructor(): void
    {
        $someData = 'Corn';
        $jsonResponseData = new JsonResponseData($someData);

        $jsonResponse = ($jsonResponseData)->send(new Response());

        self::assertSame($someData, $this->getJson($jsonResponse)['data']);
    }

    /**
     * @throws JsonException
     */
    public function testResponseDataCanBeSet(): void
    {
        $someData = 'Corn';
        $jsonResponseData = (new JsonResponseData())->setData($someData);

        $jsonResponse = ($jsonResponseData)->send(new Response());

        self::assertSame($someData, $this->getJson($jsonResponse)['data']);
    }

    /**
     * @throws JsonException
     */
    public function testResponseMessageCanBeSetFromConstructor(): void
    {
        $someMessage = 'Corn';
        $jsonResponseData = new JsonResponseData(message: $someMessage);

        $jsonResponse = ($jsonResponseData)->send(new Response());

        self::assertSame($someMessage, $this->getJson($jsonResponse)['message']);
    }

    /**
     * @throws JsonException
     */
    public function testResponseMessageCanBeSet(): void
    {
        $someMessage = 'Corn';
        $jsonResponseData = (new JsonResponseData())->setMessage($someMessage);

        $jsonResponse = ($jsonResponseData)->send(new Response());

        self::assertSame($someMessage, $this->getJson($jsonResponse)['message']);
    }

    /**
     * @throws JsonException
     */
    public function testResponseSuccessCanBeSet(): void
    {
        $jsonResponseData = (new JsonResponseData())->setSuccess(false);

        $jsonResponse = ($jsonResponseData)->send(new Response());

        self::assertFalse($this->getJson($jsonResponse)['success']);
    }


    /**
     * @param ResponseInterface $jsonResponse
     * @return array<string, mixed>
     */
    private function getJson(ResponseInterface $jsonResponse): array
    {
        return (array)json_decode((string)$jsonResponse->getBody(), true);
    }
}
