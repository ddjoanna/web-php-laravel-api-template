<?php

namespace Tests\Unit\Services;

use App\Services\UserService;
use App\Repositories\UserRepository;
use App\ValueObjects\UserValueObject;
use App\Entities\User as UserEntity;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    protected UserService $service;
    protected $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // 模擬 UserRepository
        $this->repositoryMock = Mockery::mock(UserRepository::class);

        // 使用模擬的 Repository 建立 UserService 實例
        $this->service = new UserService($this->repositoryMock);
    }

    /**
     * 測試創建使用者
     */
    public function testCreate()
    {
        $userValueObject = new UserValueObject(
            'Test User',
            'testuser@example.com',
            'password123',
        );

        // 模擬 UserRepository 的 create 方法
        $mockUserEntity = Mockery::mock(UserEntity::class);
        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($userValueObject)
            ->andReturn($mockUserEntity);

        $result = $this->service->create($userValueObject);

        $this->assertInstanceOf(UserEntity::class, $result);
    }

    /**
     * 測試查找使用者
     */
    public function testFind()
    {
        $id = 1;
        $withToken = false;
        $withPassword = false;

        // 模擬 UserRepository 的 find 方法
        $mockUserEntity = Mockery::mock(UserEntity::class);
        $this->repositoryMock
            ->shouldReceive('find')
            ->once()
            ->with($id, $withToken, $withPassword)
            ->andReturn($mockUserEntity);

        $result = $this->service->find($id, $withToken, $withPassword);

        $this->assertInstanceOf(UserEntity::class, $result);
    }

    /**
     * 測試查找不存在的使用者
     */
    public function testFindNonExistentUser()
    {
        $id = 1;
        $withToken = false;
        $withPassword = false;

        // 模擬 UserRepository 的 find 方法
        $this->repositoryMock
            ->shouldReceive('find')
            ->once()
            ->with($id, $withToken, $withPassword)
            ->andReturn(null);

        $result = $this->service->find($id, $withToken, $withPassword);

        $this->assertNull($result);
    }

    /**
     * 測試通過電子郵件查找使用者
     */
    public function testFindByEmail()
    {
        $email = 'test@example.com';
        $withToken = false;
        $withPassword = false;

        // 模擬 UserRepository 的 findByEmail 方法
        $mockUserEntity = Mockery::mock(UserEntity::class);
        $this->repositoryMock
            ->shouldReceive('findByEmail')
            ->once()
            ->with($email, $withToken, $withPassword)
            ->andReturn($mockUserEntity);

        $result = $this->service->findByEmail($email, $withToken, $withPassword);

        $this->assertInstanceOf(UserEntity::class, $result);
    }

    /**
     * 測試登出
     */
    public function testLogout()
    {
        $token = 'test-token';

        // 模擬 UserRepository 的 logout 方法
        $this->repositoryMock
            ->shouldReceive('logout')
            ->once()
            ->with($token)
            ->andReturn(true);

        $result = $this->service->logout($token);

        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
