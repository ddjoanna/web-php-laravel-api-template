<?php

namespace App\Libraries\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient implements HttpClientInterface
{
    protected Client $client;

    public function __construct(HttpClientConfig $config)
    {
        $guzzleConfig = [
            'base_uri' => $config->getBaseUri(),
            'timeout' => $config->getTimeout(),
            'headers' => $config->getHeaders(),
            'verify' => $config->isVerifySsl(),
        ];

        // 合併額外選項
        $guzzleConfig = array_merge($guzzleConfig, $config->getExtraOptions());

        $this->client = new Client($guzzleConfig);
    }

    public function request(HttpRequest $request): HttpResponse
    {
        try {
            $response = $this->client->request(
                $request->getMethod(),
                $request->getUri(),
                $request->getOptions()
            );

            return $this->createHttpResponse($response);
        } catch (RequestException $e) {
            // 如果有回應，嘗試從回應中建立 HttpResponse
            if ($e->hasResponse()) {
                return $this->createHttpResponse($e->getResponse());
            }

            // 無回應時，回傳自訂錯誤 HttpResponse
            return new HttpResponse(
                0, // 狀態碼 0 代表無回應
                [],
                $e->getMessage()
            );
        }
    }

    protected function createHttpResponse(ResponseInterface $response): HttpResponse
    {
        return new HttpResponse(
            $response->getStatusCode(),
            $response->getHeaders(),
            (string) $response->getBody()
        );
    }
}
