<?php

namespace Tests\Unit\UseCases\UserProfile;

use Tests\TestCase;
use App\UseCases\UserProfile\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use App\Models\User;

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

        $this->assertArrayHasKey('id', $rules);
        $this->assertEquals('required|integer|exists:users,id', $rules['id']);
    }


    // 測試自定義錯誤訊息
    public function testCustomMessages()
    {
        $request = new Request();

        $expectedMessages = [
            'id.required' => '用戶 ID 欄位是必填的。',
            'id.integer' => '用戶 ID 欄位必須是一個整數。',
            'id.exists' => '所選的 用戶 ID 無效。',
        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    public function testPrepareForValidationMergesUserId()
    {
        $user = User::factory()->create();

        $request = new Request();

        $request->setUserResolver(fn() => $user);
        // Mock user() 方法
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $reflection = new \ReflectionClass($request);
        $method = $reflection->getMethod('prepareForValidation');
        $method->setAccessible(true);
        $method->invoke($request);

        $this->assertEquals($user->id, $request->input('id'));
    }

    // 測試驗證通過情境
    public function testValidRequestPasses()
    {
        $user = \App\Models\User::factory()->create();

        $request = new Request();
        $request->merge(['id' => $user->id]);

        $validator = Validator::make($request->all(), $request->rules());

        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails([], 'id', '用戶 ID 欄位是必填的。');
        $this->assertValidationFails(['id' => 'abc'], 'id', '用戶 ID 欄位必須是一個整數。');
        $this->assertValidationFails(['id' => 999], 'id', '所選的 用戶 ID 無效。');
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
