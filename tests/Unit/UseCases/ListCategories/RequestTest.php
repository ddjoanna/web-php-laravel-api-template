<?php

namespace Tests\Unit\UseCases\ListCategories;

use Tests\TestCase;
use App\UseCases\ListCategories\Request;
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

        $this->assertArrayHasKey('name', $rules);
        $this->assertEquals('nullable|string', $rules['name']);
        $this->assertArrayHasKey('layer', $rules);
        $this->assertEquals('nullable|integer|min:1', $rules['layer']);
    }


    // 測試自定義錯誤訊息
    public function testCustomMessages()
    {
        $request = new Request();

        $expectedMessages = [
            'name.string' => '分類名稱 欄位必須是一個字串。',
            'layer.integer' => '層級 欄位必須是一個整數。',
            'layer.min' => [
                'file' => '層級 欄位必須至少為 1 KB。',
                'numeric' => '層級 欄位必須至少為 1。',
                'string' => '層級 欄位必須至少為 1 個字元。',
                'array' => '層級 欄位必須至少有 1 個項目。',
            ],

        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    // 測試驗證通過情境
    public function testValidRequestPasses()
    {
        $request = new Request();
        $request->merge([
            'name' => 'Test Category',
            'layer' => null,
        ]);

        $validator = Validator::make($request->all(), $request->rules());

        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails(['layer' => 'abc'], 'layer', '層級 欄位必須是一個整數。');
        $this->assertValidationFails(['layer' => 0], 'layer', '層級 欄位必須至少為 1。');
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
