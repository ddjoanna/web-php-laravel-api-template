<?php

namespace App\Http\Controllers;

use App\Factories\UserUseCaseFactory;
use App\UseCases\UserRegister;
use App\UseCases\UserLogin;
use App\UseCases\UserLogout;
use App\UseCases\UserProfile;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected UserUseCaseFactory $userUseCaseFactory;

    public function __construct(UserUseCaseFactory $userUseCaseFactory)
    {
        $this->userUseCaseFactory = $userUseCaseFactory;
    }

    /**
     * 用戶註冊
     */
    public function register(UserRegister\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->userUseCaseFactory->makeUserRegisterUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }

    /**
     * 用戶登入
     */
    public function login(UserLogin\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->userUseCaseFactory->makeUserLoginUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }

    /**
     * 用戶登出
     */
    public function logout(UserLogout\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->userUseCaseFactory->makeUserLogoutUseCase();
        $usecase->execute($request);
        return $response->success(204, 'success');
    }

    /**
     * 獲取當前登入用戶的資訊
     */
    public function me(UserProfile\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->userUseCaseFactory->makeUserProfileUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }
}
