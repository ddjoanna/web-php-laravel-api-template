<?php

namespace Tests\Unit\UseCases\UserLogin;

use Tests\TestCase;
use App\UseCases\UserLogin\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class RequestTest extends TestCase
{
    use RefreshDatabase;

    protected $routeMock;

    protected function setUp(): void
    {
        parent::setUp();
    }

    // 測試 rules 方法
    public function testRules()
    {
        $request = new Request();
        $rules = $request->rules();

        $this->assertArrayHasKey('email', $rules);
        $this->assertEquals('required|string', $rules['email']);
        $this->assertArrayHasKey('password', $rules);
        $this->assertEquals('required|string', $rules['password']);
    }

    // 測試自定義錯誤訊息
    public function testCustomMessages()
    {
        $request = new Request();

        $expectedMessages = [
            'email.required' => '電子郵件 欄位是必填的。',
            'password.required' => '密碼 欄位是必填的。',
        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    // 測試驗證通過情境
    public function testValidRequestPasses()
    {
        $request = new Request();
        $request->merge([
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ]);

        $validator = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails(['email' => ''], 'email', '電子郵件 欄位是必填的。');
        $this->assertValidationFails(['password' => ''], 'password', '密碼 欄位是必填的。');
    }

    // 輔助方法：驗證特定規則失敗
    protected function assertValidationFails(array $data, string $field, string $message)
    {
        $request = new Request();
        $request->merge($data);

        $validator = Validator::make($request->all(), $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey($field, $validator->errors()->toArray());

        $errorMessages = $validator->errors()->get($field);
        $this->assertIsArray($errorMessages);
        $this->assertStringContainsString($message, implode(' ', $errorMessages));
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
