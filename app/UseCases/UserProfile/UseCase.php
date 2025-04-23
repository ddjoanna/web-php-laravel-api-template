<?php

namespace App\UseCases\UserProfile;

use App\UseCases\UserProfile\Request;
use App\UseCases\UserProfile\Response;
use App\Services\UserService;
use App\Exceptions\NotFoundException;

class UseCase
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $user = $this->service->find($request->input('id'));
        if (!$user) {
            throw new NotFoundException('User not found');
        }
        $response = new Response();
        $response->setUser($user);
        return $response;
    }
}
