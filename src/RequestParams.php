<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager;

use Psr\Http\Message\RequestInterface;

/**
 * Request params fetcher
 */
class RequestParams
{
    /**
     * @var array<string, mixed>
     */
    private array $params;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->params = $this->parseParams($request);
    }

    /**
     * Returns param value by name
     * @param string $name
     * @param mixed|null $defaultValue default value if no param was found
     * @return mixed
     */
    public function get(string $name, mixed $defaultValue = null): mixed
    {
        return $this->params[$name] ?? $defaultValue;
    }

    /**
     * @param string ...$names
     * @return bool
     */
    public function has(...$names): bool
    {
        foreach ($names as $name) {
            if (!isset($this->params[$name])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param RequestInterface $request
     * @return array<string, mixed>
     */
    public function parseParams(RequestInterface $request): array
    {
        $json = json_decode($request->getBody()->getContents(), true);

        if (!is_array($json)) {
            return [];
        }

        return $json;
    }
}
