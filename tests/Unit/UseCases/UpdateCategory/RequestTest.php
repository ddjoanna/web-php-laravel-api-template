<?php

namespace Tests\Unit\UseCases\UpdateCategory;

use Tests\TestCase;
use App\UseCases\UpdateCategory\Request;
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
        $this->routeMock->shouldReceive('hasParameter')->with('categories')->andReturn(true);
        $this->routeMock->shouldReceive('parameter')->andReturn(123);
    }

    // 測試 rules 方法
    public function testRules()
    {
        $request = new Request();
        $rules = $request->rules();

        $this->assertArrayHasKey('id', $rules);
        $this->assertEquals('required|integer|exists:categories,id', $rules['id']);
        $this->assertArrayHasKey('name', $rules);
        $this->assertEquals('required|string', $rules['name']);
        $this->assertArrayHasKey('parent_id', $rules);
        $this->assertEquals('nullable|integer|exists:categories,id', $rules['parent_id']);
        $this->assertArrayHasKey('layer', $rules);
        $this->assertEquals('required|integer|min:1', $rules['layer']);
        $this->assertArrayHasKey('sort_order', $rules);
        $this->assertEquals('required|integer', $rules['sort_order']);
        $this->assertArrayHasKey('is_active', $rules);
        $this->assertEquals('required|boolean', $rules['is_active']);
    }


    // 測試自定義錯誤訊息
    public function testCustomMessages()
    {
        $request = new Request();

        $expectedMessages = [
            'id.required' => '產品分類 ID 欄位是必填的。',
            'id.integer' => '產品分類 ID 欄位必須是一個整數。',
            'id.exists' => '所選的 產品分類 ID 無效。',
            'name.required' => '分類名稱 欄位是必填的。',
            'name.string' => '分類名稱 欄位必須是一個字串。',
            'parent_id.integer' => '上層分類 ID 欄位必須是一個整數。',
            'parent_id.exists' => '所選的 上層分類 ID 無效。',
            'layer.required' => '層級 欄位是必填的。',
            'layer.integer' => '層級 欄位必須是一個整數。',
            'layer.min' => [
                'file' => '層級 欄位必須至少為 1 KB。',
                'numeric' => '層級 欄位必須至少為 1。',
                'string' => '層級 欄位必須至少為 1 個字元。',
                'array' => '層級 欄位必須至少有 1 個項目。',
            ],
            'sort_order.required' => '排序權重 欄位是必填的。',
            'sort_order.integer' => '排序權重 欄位必須是一個整數。',
            'is_active.required' => '是否啟用 欄位是必填的。',
            'is_active.boolean' => '是否啟用 欄位必須是 true 或 false。',
        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    // 測試路由參數自動合併到請求數據
    public function testRouteParameterMerging()
    {
        $request = Request::create('/categories/123', 'PUT');

        // 設定路由解析器
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
        $product = \App\Models\Category::factory()->create();

        $request = new Request();
        $request->merge([
            'id' => $product->id,
            'name' => 'Updated Category Name',
            'parent_id' => $product->parent_id,
            'layer' => $product->layer,
            'sort_order' => $product->sort_order,
            'is_active' => $product->is_active,
        ]);

        $validator = Validator::make($request->all(), $request->rules());

        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails([], 'id', '產品分類 ID 欄位是必填的。');
        $this->assertValidationFails(['id' => 'abc'], 'id', '產品分類 ID 欄位必須是一個整數。');
        $this->assertValidationFails(['id' => 999], 'id', '所選的 產品分類 ID 無效。');
        $this->assertValidationFails(['name' => ''], 'name', '名稱 欄位是必填的。');
        $this->assertValidationFails(['parent_id' => 'abc'], 'parent_id', '上層分類 ID 欄位必須是一個整數。');
        $this->assertValidationFails(['layer' => ''], 'layer', '層級 欄位是必填的。');
        $this->assertValidationFails(['layer' => 'abc'], 'layer', '層級 欄位必須是一個整數。');
        $this->assertValidationFails(['sort_order' => ''], 'sort_order', '排序權重 欄位是必填的。');
        $this->assertValidationFails(['sort_order' => 'abc'], 'sort_order', '排序權重 欄位必須是一個整數。');
        $this->assertValidationFails(['is_active' => ''], 'is_active', '是否啟用 欄位是必填的。');
        $this->assertValidationFails(['is_active' => 'abc'], 'is_active', '是否啟用 欄位必須是 true 或 false。');
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
