<?php

namespace Tests\Unit\UseCases\UserLogout;

use App\UseCases\UserLogout\Request;
use App\UseCases\UserLogout\UseCase;
use App\Services\UserService;
use App\Entities\User as UserEntity;
use App\Entities\Props\UserProps;
use Mockery;
use Tests\TestCase;

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
        // Mock find method of UserService
        $this->serviceMock
            ->shouldReceive('logout')
            ->once()
            ->with('mocked-token')
            ->andReturn(true);

        $request = new Request();
        $request->merge(['token' => 'mocked-token']);

        $result = $this->useCase->execute($request);
        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
