<?php

namespace App\Libraries\HttpClient;

class HttpClientConfigBuilder
{
    private HttpClientConfig $config;

    public function __construct()
    {
        $this->config = new HttpClientConfig();
    }

    public function baseUri(string $uri): self
    {
        // 使用 setter 設定 baseUri
        $this->config->setBaseUri(rtrim($uri, '/'));
        return $this;
    }

    public function timeout(int $seconds): self
    {
        $this->config->setTimeout(max(0, $seconds));
        return $this;
    }

    public function addHeader(string $key, string $value): self
    {
        $headers = $this->config->getHeaders();
        $headers[$key] = $value;
        $this->config->setHeaders($headers);
        return $this;
    }

    public function headers(array $headers): self
    {
        foreach ($headers as $key => $value) {
            $this->addHeader($key, $value);
        }
        return $this;
    }

    public function verifySsl(bool $verify): self
    {
        $this->config->setVerifySsl($verify);
        return $this;
    }

    public function maxRetries(int $count): self
    {
        $this->config->setMaxRetries(max(0, $count));
        return $this;
    }

    public function retryDelayMs(int $milliseconds): self
    {
        $this->config->setRetryDelayMs(max(0, $milliseconds));
        return $this;
    }

    public function extraOptions(array $options): self
    {
        $this->config->setExtraOptions($options);
        return $this;
    }

    public function build(): HttpClientConfig
    {
        if (empty($this->config->getBaseUri())) {
            throw new \InvalidArgumentException('Base URI cannot be empty');
        }
        return $this->config;
    }
}
