<?php

namespace App\UseCases\UserRegister;

use App\UseCases\UserRegister\Request;
use App\UseCases\UserRegister\Response;
use App\Services\UserService;
use App\Jobs\ExampleJob;

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

        // 執行指定Job
        // ExampleJob::dispatch($user);
        // 設定事件&多個監聽者，執行多個Job
        event(new \App\Events\UserRegisteredEvent($user));

        $response = new Response();
        $response->setUser($user);
        $response->setToken($user->getApiToken());

        return $response;
    }
}
