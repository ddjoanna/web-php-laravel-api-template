<?php

namespace App\Services;

use App\Libraries\HttpClient\HttpClientInterface;
use App\Libraries\HttpClient\HttpRequest;
use App\Libraries\HttpClient\HttpResponse;
use App\Libraries\RateLimiter\RateLimiterInterface;

class ThirdPartyApiExampleService
{
    protected HttpClientInterface $httpClient;
    protected ?RateLimiterInterface $rateLimiter;
    protected int $maxRetries;
    protected int $retryDelayMs;

    public function __construct(
        HttpClientInterface $httpClient,
        ?RateLimiterInterface $rateLimiter = null,
        int $maxRetries = 2,
        int $retryDelayMs = 500
    ) {
        $this->httpClient = $httpClient;
        $this->rateLimiter = $rateLimiter;
        $this->maxRetries = max(0, $maxRetries);
        $this->retryDelayMs = max(100, $retryDelayMs);
    }

    public function requestSomething()
    {
        $attempt = 0;
        $response = null;

        $apiKey = config('services.example.api_key');
        $apiUrl = config('services.example.base_uri', 'https://api.example.com') . '/v1/something';

        do {
            $attempt++;

            // 限流檢查
            if ($this->rateLimiter && !$this->rateLimiter->attempt()) {
                $this->waitForRetry();
                continue;
            }

            $request = new HttpRequest(
                'GET',
                $apiUrl,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiKey,
                    ],
                ]
            );

            $response = $this->httpClient->request($request);

            $status = $response->getStatusCode();

            if ($this->shouldRetry($status)) {
                $this->waitForRetry();
                continue;
            }

            // 成功或非重試錯誤，直接回傳
            return $this->parseResponseWithSomething($response);
        } while ($attempt <= $this->maxRetries);

        // 超過最大重試次數，回傳最後一次回應（可能是錯誤）
        return $this->parseResponseWithSomething($response);
    }

    private function parseResponseWithSomething(HttpResponse $response)
    {
        // TODO: 建議實作 DTO 或統一格式回傳
        return $response;
    }

    private function shouldRetry(int $statusCode): bool
    {
        return $statusCode === 0 ||  // 無回應或網路錯誤
            $statusCode === 429 ||   // Too Many Requests
            ($statusCode >= 500 && $statusCode < 600); // 伺服器錯誤
    }

    private function waitForRetry(): void
    {
        usleep($this->retryDelayMs * 1000);
    }
}
