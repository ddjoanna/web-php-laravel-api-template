<?php

namespace Tests\Unit\UseCases\DeleteProduct;

use Tests\TestCase;
use App\UseCases\DeleteProduct\Request;
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

        // Mock route
        $this->routeMock = Mockery::mock(\Illuminate\Routing\Route::class);
        $this->routeMock->shouldReceive('hasParameter')->with('product')->andReturn(true);
        $this->routeMock->shouldReceive('parameter')->andReturn(123);
    }

    // 測試 rules 方法
    public function testRules()
    {
        $request = new Request();
        $rules = $request->rules();

        $this->assertArrayHasKey('id', $rules);
        $this->assertEquals('required|integer|exists:products,id', $rules['id']);
    }


    // 測試自定義錯誤訊息
    public function testCustomMessages()
    {
        $request = new Request();

        $expectedMessages = [
            'id.required' => '產品 ID 欄位是必填的。',
            'id.integer' => '產品 ID 欄位必須是一個整數。',
            'id.exists' => '所選的 產品 ID 無效。',
        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    // 測試路由參數自動合併到請求數據
    public function testRouteParameterMerging()
    {
        $request = Request::create('/categories/123', 'Delete');

        $request->setRouteResolver(function () {
            return $this->routeMock;
        });

        // 使用反射機制訪問受保護的 prepareForValidation 方法
        $reflection = new \ReflectionClass($request);
        $method = $reflection->getMethod('prepareForValidation');
        $method->setAccessible(true);

        // 調用方法並執行合併邏輯
        $method->invoke($request);

        // 驗證路由參數是否正確合併到請求數據
        $this->assertEquals(123, $request->input('id'));
    }

    // 測試驗證通過情境
    public function testValidRequestPasses()
    {
        $product = \App\Models\Product::factory()->create();

        $request = new Request();
        $request->merge(['id' => $product->id]);

        $validator = Validator::make($request->all(), $request->rules());

        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails([], 'id', '產品 ID 欄位是必填的。');
        $this->assertValidationFails(['id' => 'abc'], 'id', '產品 ID 欄位必須是一個整數。');
        $this->assertValidationFails(['id' => 999], 'id', '所選的 產品 ID 無效。');
    }

    // 驗證特定規則失敗
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
