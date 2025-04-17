<?php

namespace Tests\Unit\UseCases\CreateProduct;

use Tests\TestCase;
use App\UseCases\CreateProduct\Request;
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
        $this->assertEquals('required', $rules['name']);
        $this->assertArrayHasKey('description', $rules);
        $this->assertEquals('required', $rules['description']);
        $this->assertArrayHasKey('price', $rules);
        $this->assertEquals('required|numeric', $rules['price']);
    }

    // 測試自定義錯誤訊息
    public function testCustomMessages()
    {
        $request = new Request();

        $expectedMessages = [
            'name.required' => '名稱 欄位是必填的。',
            'description.required' => '描述 欄位是必填的。',
            'price.required' => '價格 欄位是必填的。',
            'price.numeric' => '價格 欄位必須是一個數字。',
        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    // 測試驗證通過情境
    public function testValidRequestPasses()
    {
        $request = new Request();
        $request->merge([
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 12.99,
        ]);

        $validator = Validator::make($request->all(), $request->rules());

        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails(['name' => ''], 'name', '名稱 欄位是必填的。');
        $this->assertValidationFails(['description' => ''], 'description', '描述 欄位是必填的。');
        $this->assertValidationFails(['price' => ''], 'price', '價格 欄位是必填的。');
        $this->assertValidationFails(['price' => 'abc'], 'price', '價格 欄位必須是一個數字。');
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
