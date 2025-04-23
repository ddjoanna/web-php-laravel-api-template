<?php

namespace Tests\Unit\Factories;

use App\Factories\UserFactory;
use App\Entities\User as UserEntity;
use App\Entities\Props\UserProps;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    /**
     * 測試創建單一用戶
     */
    public function testCreate()
    {
        $userData = [
            'id' => 1,
            'name' => 'Test User',
            'email' => 'This is a test product.',
        ];

        $userEntity = UserFactory::create($userData);

        $this->assertInstanceOf(UserEntity::class, $userEntity);
        $this->assertEquals(1, $userEntity->getId());

        $userProps = $userEntity->getProps();
        $this->assertInstanceOf(UserProps::class, $userProps);
        $this->assertEquals('Test User', $userProps->getName());
        $this->assertEquals('This is a test product.', $userProps->getEmail());
    }

    /**
     * 測試批量創建用戶
     */
    public function testBulk()
    {
        $usersData = [
            [
                'id' => 1,
                'name' => 'User 1',
                'email' => 'Email 1',
            ],
            [
                'id' => 2,
                'name' => 'User 2',
                'email' => 'Email 2',
            ],
        ];

        $userEntities = UserFactory::bulk($usersData);

        $this->assertIsArray($userEntities);
        $this->assertCount(2, $userEntities);

        foreach ($userEntities as $index => $userEntity) {
            $this->assertInstanceOf(UserEntity::class, $userEntity);
            $this->assertEquals($index + 1, $userEntity->getId());

            $userProps = $userEntity->getProps();
            $this->assertInstanceOf(UserProps::class, $userProps);
            $this->assertEquals("User " . ($index + 1), $userProps->getName());
            $this->assertEquals("Email " . ($index + 1), $userProps->getEmail());
        }
    }
}
