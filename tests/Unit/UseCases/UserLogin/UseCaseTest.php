<?php

namespace Tests\Unit\UseCases\UserLogin;

use App\UseCases\UserLogin\Request;
use App\UseCases\UserLogin\Response;
use App\UseCases\UserLogin\UseCase;
use App\Services\UserService;
use App\Entities\User as UserEntity;
use App\Entities\Props\UserProps;
use Tests\TestCase;
use Mockery;
use App\Exceptions\ValidationException;

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

    public function testExecute()
    {
        $request = new Request();
        $request->merge([
            'email' => 'testuser@example.com',
            'password' => 'password123'
        ]);

        $userPropsMock = Mockery::mock(UserProps::class);
        $userPropsMock->shouldReceive('getName')->andReturn('Test User');
        $userPropsMock->shouldReceive('getEmail')->andReturn('testuser@example.com');

        $userEntityMock = Mockery::mock(UserEntity::class);
        $userEntityMock->shouldReceive('getId')->andReturn(1);
        $userEntityMock->shouldReceive('getProps')->andReturn($userPropsMock);
        $userEntityMock->shouldReceive('getApiToken')->andReturn('token');
        $userEntityMock->shouldReceive('validatePassword')->andReturn(true);

        $this->serviceMock->shouldReceive('findByEmail')
            ->once()
            ->with($request->input('email'), true, true)
            ->andReturn($userEntityMock);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertEquals([
            "user" => [
                "id" => 1,
                "name" => "Test User",
                "email" => "testuser@example.com",
            ],
            "token" => 'token',
        ], $response->toArray());
    }

    public function testExecuteFailureWithInvalidEmail()
    {
        $request = new Request();
        $request->merge([
            'email' => 'testuser@example.com',
            'password' => 'password123'
        ]);

        $this->serviceMock->shouldReceive('findByEmail')
            ->once()
            ->with($request->input('email'), true, true)
            ->andReturn(null);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('email or password is invalid');

        $this->useCase->execute($request);
    }

    public function testExecuteFailureWithInvalidPassword()
    {
        $request = new Request();
        $request->merge([
            'email' => 'testuser@example.com',
            'password' => 'password123'
        ]);

        $userPropsMock = Mockery::mock(UserProps::class);
        $userPropsMock->shouldReceive('getName')->andReturn('Test User');
        $userPropsMock->shouldReceive('getEmail')->andReturn('testuser@example.com');

        $userEntityMock = Mockery::mock(UserEntity::class);
        $userEntityMock->shouldReceive('getId')->andReturn(1);
        $userEntityMock->shouldReceive('getProps')->andReturn($userPropsMock);
        $userEntityMock->shouldReceive('getApiToken')->andReturn('token');
        $userEntityMock->shouldReceive('validatePassword')->andReturn(false);

        $this->serviceMock->shouldReceive('findByEmail')
            ->once()
            ->with($request->input('email'), true, true)
            ->andReturn($userEntityMock);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('email or password is invalid');

        $this->useCase->execute($request);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
