<?php

namespace App\Libraries\HttpClient;

interface HttpClientInterface
{
    public function request(HttpRequest $request): HttpResponse;
}
