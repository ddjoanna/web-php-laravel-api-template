<?php

namespace App\UseCases\UserLogin;

use App\UseCases\UserLogin\Request;
use App\UseCases\UserLogin\Response;
use App\Services\UserService;
use App\Exceptions\ValidationException;

class UseCase
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $user = $this->service->findByEmail($request->input('email'), true, true);
        if ($user === null) {
            throw new ValidationException('email or password is invalid');
        }

        $check = $user->validatePassword($request->input('password'));
        if ($check === false) {
            throw new ValidationException('email or password is invalid');
        }

        $response = new Response();
        $response->setUser($user);
        $response->setToken($user->getApiToken());
        return $response;
    }
}
