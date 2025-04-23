<?php

namespace App\UseCases\UserRegister;

use App\UseCases\UserRegister\Request;
use App\UseCases\UserRegister\Response;
use App\Services\UserService;

class UseCase
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $userVo = new \App\ValueObjects\UserValueObject(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
        );

        $user = $this->service->create($userVo);


        $response = new Response();
        $response->setUser($user);
        $response->setToken($user->getApiToken());

        return $response;
    }
}
