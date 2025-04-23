<?php

namespace Tests\Unit\Entities;

use App\Entities\User;
use App\Entities\Props\UserProps;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * 測試建構子
     */
    public function testConstructor()
    {
        $id = 1;
        $name = 'Test User';
        $email = 'test@example.com';

        $userProps = new UserProps($name, $email);
        $user = new User($id, $userProps);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($name, $user->getProps()->getName());
        $this->assertEquals($email, $user->getProps()->getEmail());
    }

    /**
     * 測試設置屬性
     */
    public function testSetProps()
    {
        $id = 1;
        $initialName = 'Initial Name';
        $initialEmail = 'Initial Email';

        $initialProps = new UserProps($initialName, $initialEmail);
        $user = new User($id, $initialProps);

        $newName = 'Updated Name';
        $newEmail = 'Updated Email';

        $newProps = new UserProps($newName, $newEmail);
        $user->setProps($newProps);

        $this->assertEquals($newName, $user->getProps()->getName());
        $this->assertEquals($newEmail, $user->getProps()->getEmail());
    }
}
