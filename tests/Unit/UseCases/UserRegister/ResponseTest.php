<?php

namespace Tests\Unit\UseCases\UserRegister;

use PHPUnit\Framework\TestCase;
use App\UseCases\UserRegister\Response;
use App\Entities\User;
use App\Entities\Props\UserProps;

class ResponseTest extends TestCase
{
    protected Response $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->response = new Response();
    }

    public function testSetUser()
    {
        $data = [
            'id' => 1,
            'name' => 'Test User',
            'email' => 'testuser@example.com',
        ];

        $entity = new User($data['id'], new UserProps(
            $data['name'],
            $data['email'],
        ));
        $this->response->setUser($entity);
        $this->response->setToken('token');

        $this->assertEquals([
            "user" => $data,
            "token" => 'token',
        ], $this->response->toArray());
    }

    public function testHandleEmptyUserAndToken()
    {
        $this->assertEquals([
            "user" => null,
            "token" => null
        ], $this->response->toArray());
    }
}
