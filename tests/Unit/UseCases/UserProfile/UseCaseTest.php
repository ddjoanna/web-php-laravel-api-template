<?php

namespace Tests\Unit\UseCases\UserProfile;

use App\UseCases\UserProfile\Request;
use App\UseCases\UserProfile\Response;
use App\UseCases\UserProfile\UseCase;
use App\Services\UserService;
use App\Entities\User as UserEntity;
use App\Entities\Props\UserProps;
use Mockery;
use Tests\TestCase;
use App\Exceptions\NotFoundException;

class UseCaseTest extends TestCase
{
    protected $serviceMock;
    protected UseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock UserService
        $this->serviceMock = Mockery::mock(UserService::class);

        // Create UseCase instance with mock service
        $this->useCase = new UseCase($this->serviceMock);
    }

    // 測試取得用戶成功
    public function testExecuteSuccess()
    {
        $userId = 1;

        // Mock UserProps
        $userPropsMock = Mockery::mock(UserProps::class);
        $userPropsMock->shouldReceive('getName')->andReturn('Test User');
        $userPropsMock->shouldReceive('getEmail')->andReturn('testuser@example.com');

        // Mock UserEntity
        $userEntityMock = Mockery::mock(UserEntity::class);
        $userEntityMock->shouldReceive('getId')->andReturn($userId);
        $userEntityMock->shouldReceive('getProps')->andReturn($userPropsMock);
        $userEntityMock->shouldReceive('getApiToken')->andReturn('token');

        // Mock find method of UserService
        $this->serviceMock
            ->shouldReceive('find')
            ->once()
            ->with($userId)
            ->andReturn($userEntityMock);

        $request = new Request();
        $request->merge(['id' => $userId]);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertEquals([
            "id" => $userId,
            "name" => "Test User",
            "email" => "testuser@example.com",
        ], $response->toArray());
    }

    // 測試取得用戶失敗
    public function testExecuteFailure()
    {
        $userId = 1;

        // Mock find method of UserService
        $this->serviceMock
            ->shouldReceive('find')
            ->once()
            ->with($userId)
            ->andReturn(null);

        $request = new Request();
        $request->merge(['id' => $userId]);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('User not found');

        $this->useCase->execute($request);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
