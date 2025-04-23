<?php

namespace Tests\Unit\UseCases\UserLogout;

use Tests\TestCase;
use App\UseCases\UserLogout\Request;
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

        $this->assertArrayHasKey('token', $rules);
        $this->assertEquals('required|string', $rules['token']);
    }


    // 測試自定義錯誤訊息
    public function testCustomMessages()
    {
        $request = new Request();

        $expectedMessages = [
            'token.required' => 'Token 欄位是必填的。',
            'token.string' => 'Token 欄位必須是一個字串。',
        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    public function testPrepareForValidationMergesToken()
    {
        // 模擬 token 物件
        $tokenMock = (object) ['token' => 'mocked-token'];

        // Mock user 物件，並模擬 currentAccessToken() 回傳 tokenMock
        $userMock = Mockery::mock(\App\Models\User::class);
        $userMock->shouldReceive('currentAccessToken')->andReturn($tokenMock);

        $request = new \App\UseCases\UserLogout\Request();

        // 讓 user() 回傳 userMock
        $request->setUserResolver(fn() => $userMock);

        // 用 Reflection 呼叫 protected 的 prepareForValidation
        $reflection = new \ReflectionClass($request);
        $method = $reflection->getMethod('prepareForValidation');
        $method->setAccessible(true);
        $method->invoke($request);

        // 斷言 token 被合併到 input 中
        $this->assertEquals('mocked-token', $request->input('token'));
    }

    // 測試驗證通過情境
    public function testValidRequestPasses()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('api')->plainTextToken;

        $request = new Request();
        $request->merge(['token' => $token]);

        $validator = Validator::make($request->all(), $request->rules());

        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails(['token' => ''], 'token', 'Token 欄位是必填的。');
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
