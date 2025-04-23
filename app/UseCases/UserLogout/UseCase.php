<?php

namespace App\UseCases\UserLogout;

use App\Services\UserService;

class UseCase
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): bool
    {
        $token = $request->input('token');
        return $this->service->logout($token);
    }
}
