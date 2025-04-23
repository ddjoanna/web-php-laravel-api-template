<?php

namespace Tests\Unit\UseCases\UserRegister;

use App\UseCases\UserRegister\Request;
use App\UseCases\UserRegister\Response;
use App\UseCases\UserRegister\UseCase;
use App\Services\UserService;
use App\ValueObjects\UserValueObject;
use App\Entities\User as UserEntity;
use App\Entities\Props\UserProps;
use Tests\TestCase;
use Mockery;

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
            'name' => 'Test User',
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

        $this->serviceMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof UserValueObject &&
                    $arg->getName() === 'Test User' &&
                    $arg->getEmail() === 'testuser@example.com';
            }))
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

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
