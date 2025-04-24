<?php

namespace App\Libraries\HttpClient;

class HttpClientConfig
{
    private string $baseUri = '';
    private int $timeout = 10;
    private array $headers = [];
    private bool $verifySsl = true;
    private int $maxRetries = 0;
    private int $retryDelayMs = 0;
    private array $extraOptions = [];

    public static function builder(): HttpClientConfigBuilder
    {
        return new HttpClientConfigBuilder();
    }

    public function setBaseUri(string $baseUri): void
    {
        $this->baseUri = rtrim($baseUri, '/');
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function setTimeout(int $timeout): void
    {
        $this->timeout = max(0, $timeout);
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setVerifySsl(bool $verifySsl): void
    {
        $this->verifySsl = $verifySsl;
    }

    public function isVerifySsl(): bool
    {
        return $this->verifySsl;
    }

    public function setMaxRetries(int $maxRetries): void
    {
        $this->maxRetries = max(0, $maxRetries);
    }

    public function getMaxRetries(): int
    {
        return $this->maxRetries;
    }

    public function setRetryDelayMs(int $retryDelayMs): void
    {
        $this->retryDelayMs = max(0, $retryDelayMs);
    }

    public function getRetryDelayMs(): int
    {
        return $this->retryDelayMs;
    }

    public function setExtraOptions(array $extraOptions): void
    {
        $this->extraOptions = $extraOptions;
    }

    public function getExtraOptions(): array
    {
        return $this->extraOptions;
    }
}
