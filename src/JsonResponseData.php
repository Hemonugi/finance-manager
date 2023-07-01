<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager;

use JsonException;
use Psr\Http\Message\ResponseInterface;

/**
 * Данные для ответа в формате json
 */
class JsonResponseData
{
    private mixed $data;
    private bool $success = true;
    private ?string $message;

    /**
     * @param mixed $data
     * @param string|null $message
     */
    public function __construct(mixed $data = [], ?string $message = null)
    {
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * @param mixed $data
     * @return JsonResponseData
     */
    public function setData(mixed $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param bool $success
     * @return JsonResponseData
     */
    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @param string|null $message
     * @return JsonResponseData
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Возвращает ответ в единообразном формате json
     *
     * @throws JsonException в случае если произошла ошибка при формировании JSON
     */
    public function send(ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(
            json_encode([
                'success' => $this->success,
                'message' => $this->message,
                'data' => $this->data,
            ], JSON_THROW_ON_ERROR)
        );

        return $response->withHeader('Content-Type', 'application/json');
    }
}
