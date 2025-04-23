<?php

namespace Tests\Unit\Repositories;

use App\Repositories\UserRepository;
use App\Entities\User as UserEntity;
use App\ValueObjects\UserValueObject;
use App\Entities\Props\UserProps;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(UserRepository::class);
    }

    public function testCreate()
    {

        $userValueObject = new UserValueObject(
            'Test User',
            'testuser@example.com',
            'password123',
        );

        $userEntity = $this->repository->create($userValueObject);

        $this->assertInstanceOf(UserEntity::class, $userEntity);
        $this->assertNotEmpty($userEntity->getId());

        $props = $userEntity->getProps();
        $this->assertInstanceOf(UserProps::class, $props);
        $this->assertEquals('Test User', $props->getName());
        $this->assertEquals('testuser@example.com', $props->getEmail());

        $this->assertNotEmpty($userEntity->getApiToken());

        // 資料庫確實有該使用者
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'name' => 'Test User',
        ]);
    }

    public function testFind()
    {
        $user = User::factory()->create();

        $entity = $this->repository->find($user->id, withToken: true, withPassword: true);

        $this->assertInstanceOf(UserEntity::class, $entity);
        $this->assertEquals($user->id, $entity->getId());

        $props = $entity->getProps();
        $this->assertEquals($user->name, $props->getName());
        $this->assertEquals($user->email, $props->getEmail());

        $this->assertNotEmpty($entity->getApiToken());
        $this->assertEquals($user->password, $entity->getPasswordHash());
    }

    public function testFindByEmail()
    {
        $user = User::factory()->create();

        $entity = $this->repository->findByEmail($user->email, withToken: true, withPassword: true);

        $this->assertInstanceOf(UserEntity::class, $entity);
        $this->assertEquals($user->id, $entity->getId());

        $props = $entity->getProps();
        $this->assertEquals($user->name, $props->getName());
        $this->assertEquals($user->email, $props->getEmail());

        $this->assertNotEmpty($entity->getApiToken());
        $this->assertEquals($user->password, $entity->getPasswordHash());
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        // 產生明文 token
        $plainTextToken = $user->createToken('api')->plainTextToken;

        // 用 Sanctum 的 PersonalAccessToken 查找 token 物件
        $personalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($plainTextToken);
        $this->assertNotNull($personalAccessToken);

        // 呼叫 logout，傳入明文 token
        $result = $this->repository->logout($personalAccessToken->token);
        $this->assertTrue($result);
    }
}
