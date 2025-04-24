<?php

namespace App\Libraries\HttpClient;

class CurlHttpClient implements HttpClientInterface
{
    protected HttpClientConfig $config;

    public function __construct(HttpClientConfig $config)
    {
        $this->config = $config;
    }

    public function request(HttpRequest $request): HttpResponse
    {
        $ch = curl_init();

        $this->setUrlAndQuery($ch, $request);
        $this->setMethodAndBody($ch, $request);
        $this->setHeaders($ch, $request);
        $this->setOptions($ch, $request);

        $responseRaw = curl_exec($ch);
        if ($responseRaw === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return new HttpResponse(0, [], $error);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $rawHeaders = substr($responseRaw, 0, $headerSize);
        $body = substr($responseRaw, $headerSize);

        curl_close($ch);

        $headers = $this->parseHeaders($rawHeaders);

        return new HttpResponse($statusCode, $headers, $body);
    }

    private function setUrlAndQuery($ch, HttpRequest $request): void
    {
        $uri = $this->config->getBaseUri() . $request->getUri();
        $options = $request->getOptions();

        if (strtoupper($request->getMethod()) === 'GET' && !empty($options['query'])) {
            $queryString = http_build_query($options['query']);
            $uri .= (strpos($uri, '?') === false ? '?' : '&') . $queryString;
        }

        curl_setopt($ch, CURLOPT_URL, $uri);
    }

    private function setMethodAndBody($ch, HttpRequest $request): void
    {
        $method = strtoupper($request->getMethod());
        $options = $request->getOptions();

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);

            if (isset($options['json'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($options['json']));
                // 自動設定 Content-Type
                $this->addHeaderIfNotExists($options, 'Content-Type', 'application/json');
            } elseif (isset($options['form_params'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($options['form_params']));
                $this->addHeaderIfNotExists($options, 'Content-Type', 'application/x-www-form-urlencoded');
            } elseif (isset($options['body'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $options['body']);
            }
        } elseif ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if (isset($options['body'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $options['body']);
            }
        }
    }

    private function addHeaderIfNotExists(array &$options, string $headerKey, string $headerValue): void
    {
        if (!isset($options['headers'][$headerKey])) {
            $options['headers'][$headerKey] = $headerValue;
        }
    }

    private function setHeaders($ch, HttpRequest $request): void
    {
        $options = $request->getOptions();

        // 合併 config headers 與 request headers，request headers 優先
        $headers = $this->config->getHeaders();

        if (!empty($options['headers']) && is_array($options['headers'])) {
            $headers = array_merge($headers, $options['headers']);
        }

        $formattedHeaders = [];
        foreach ($headers as $key => $value) {
            $formattedHeaders[] = $key . ': ' . $value;
        }

        if (!empty($formattedHeaders)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $formattedHeaders);
        }
    }

    private function setOptions($ch, HttpRequest $request): void
    {
        $options = $request->getOptions();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        // 以 request options 為優先，否則用 config
        if (isset($options['timeout'])) {
            curl_setopt($ch, CURLOPT_TIMEOUT, (int)$options['timeout']);
        } else {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->config->getTimeout());
        }

        // SSL 驗證設定，request options 優先
        if (isset($options['verify'])) {
            if ($options['verify'] === false) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            }
        } else {
            if (!$this->config->isVerifySsl()) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            }
        }

        // 你可以在這裡加入更多從 $this->config->getExtraOptions() 的設定
        foreach ($this->config->getExtraOptions() as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
    }

    private function parseHeaders(string $rawHeaders): array
    {
        $headers = [];
        $lines = explode("\r\n", $rawHeaders);

        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$key, $value] = explode(':', $line, 2);
                $key = trim($key);
                $value = trim($value);
                if (!isset($headers[$key])) {
                    $headers[$key] = [];
                }
                $headers[$key][] = $value;
            }
        }

        return $headers;
    }
}
