<?php

namespace App\Libraries\HttpClient;

class HttpRequest
{
    protected string $method;
    protected string $uri;
    protected array $options;

    public function __construct(string $method, string $uri, array $options = [])
    {
        $this->method = strtoupper($method);
        $this->uri = $uri;
        $this->options = $options;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
