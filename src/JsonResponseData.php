<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager;

use Psr\Http\Message\ResponseInterface;

/**
 * Данные для ответа в формате json
 */
class JsonResponseData
{

    private mixed $data;
    private bool $success;
    private ?string $message;

    public function __construct(mixed $data, bool $success = true, ?string $message = null)
    {
        $this->data = $data;
        $this->success = $success;
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

    public function send(ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(json_encode([
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}