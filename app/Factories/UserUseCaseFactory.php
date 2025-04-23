<?php

namespace App\Factories;

use App\Repositories\UserRepository;
use App\Services\UserService;
use App\UseCases\UserRegister\UseCase as UserRegisterUseCase;
use App\UseCases\UserLogin\UseCase as UserLoginUseCase;
use App\UseCases\UserLogout\UseCase as UserLogoutUseCase;
use App\UseCases\UserProfile\UseCase as UserProfileUseCase;

class UserUseCaseFactory
{
    protected UserRepository $user_repository;
    protected UserService $user_service;

    public function __construct(UserRepository $user_repository, UserService $user_service)
    {
        $this->user_repository = $user_repository;
        $this->user_service = $user_service;
    }

    public function makeUserRegisterUseCase(): UserRegisterUseCase
    {
        return new UserRegisterUseCase($this->user_service);
    }

    public function makeUserLoginUseCase(): UserLoginUseCase
    {
        return new UserLoginUseCase($this->user_service);
    }

    public function makeUserLogoutUseCase(): UserLogoutUseCase
    {
        return new UserLogoutUseCase($this->user_service);
    }

    public function makeUserProfileUseCase(): UserProfileUseCase
    {
        return new UserProfileUseCase($this->user_service);
    }
}
