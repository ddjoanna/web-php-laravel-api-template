<?php

namespace Tests\Unit\UseCases\UserProfile;

use PHPUnit\Framework\TestCase;
use App\UseCases\UserProfile\Response;
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
            'email' => 'test@example.com',
        ];

        $entity = new User($data['id'], new UserProps(
            $data['name'],
            $data['email'],
        ));
        $this->response->setUser($entity);
        $this->assertEquals($data, $this->response->toArray());
    }

    public function testHandleEmptyData()
    {
        $this->assertEquals(null, $this->response->toArray());
    }
}
