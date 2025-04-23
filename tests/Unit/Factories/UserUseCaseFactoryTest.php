<?php

namespace Tests\Unit\Factories;

use App\Factories\UserUseCaseFactory;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\UseCases\UserRegister\UseCase as UserRegisterUseCase;
use App\UseCases\UserLogin\UseCase as UserLoginUseCase;
use App\UseCases\UserLogout\UseCase as UserLogoutUseCase;
use App\UseCases\UserProfile\UseCase as UserProfileUseCase;
use PHPUnit\Framework\TestCase;

class UserUseCaseFactoryTest extends TestCase
{
    protected UserRepository $productRepository;
    protected UserService $productService;
    protected UserUseCaseFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock
        $this->productRepository = $this->createMock(UserRepository::class);
        $this->productService = $this->createMock(UserService::class);

        // 創建 factory 實例
        $this->factory = new UserUseCaseFactory($this->productRepository, $this->productService);
    }

    public function testMakeUserRegisterUseCase()
    {
        $useCase = $this->factory->makeUserRegisterUseCase();

        $this->assertInstanceOf(UserRegisterUseCase::class, $useCase);
    }

    public function testMakeUserLoginUseCase()
    {
        $useCase = $this->factory->makeUserLoginUseCase();

        $this->assertInstanceOf(UserLoginUseCase::class, $useCase);
    }

    public function testMakeUserLogoutUseCase()
    {
        $useCase = $this->factory->makeUserLogoutUseCase();

        $this->assertInstanceOf(UserLogoutUseCase::class, $useCase);
    }

    public function testMakeUserProfileUseCase()
    {
        $useCase = $this->factory->makeUserProfileUseCase();

        $this->assertInstanceOf(UserProfileUseCase::class, $useCase);
    }
}
