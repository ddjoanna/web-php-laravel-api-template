<?php

namespace Tests\Unit\Entities\Props;

use App\Entities\Props\UserProps;
use Tests\TestCase;

class UserPropsTest extends TestCase
{
    /**
     * 測試建構子
     */
    public function testConstructor()
    {
        $name = 'Test User';
        $email = 'test@example.com';

        $userProps = new UserProps($name, $email);

        $this->assertEquals($name, $userProps->getName());
        $this->assertEquals($email, $userProps->getEmail());
    }

    /**
     * 測試設置名稱
     */
    public function testSetName()
    {
        $userProps = new UserProps('Test User', 'test@example.com');
        $newName = 'Updated Name';

        $userProps->setName($newName);

        $this->assertEquals($newName, $userProps->getName());
    }

    /**
     * 測試取得產品資料
     */
    public function testGetUser()
    {
        $name = 'Test User';
        $email = 'test@example.com';

        $userProps = new UserProps($name, $email);

        $expectedResult = [
            'name' => $name,
            'email' => $email,
        ];

        $this->assertEquals($expectedResult, $userProps->getUser());
    }
}
