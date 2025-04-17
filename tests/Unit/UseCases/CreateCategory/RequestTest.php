<?php

namespace Tests\Unit\UseCases\CreateCategory;

use Tests\TestCase;
use App\UseCases\CreateCategory\Request;
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

    // 測試驗證通過情境
    public function testValidRequestPasses()
    {
        $request = new Request();
        $request->merge([
            'name' => 'Updated Category',
            'parent_id' => null,
            'layer' => 1,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $validator = Validator::make($request->all(), $request->rules());

        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails(['name' => ''], 'name', '分類名稱 欄位是必填的。');
        $this->assertValidationFails(['parent_id' => 'qqq'], 'parent_id', '上層分類 ID 欄位必須是一個整數。');
        $this->assertValidationFails(['layer' => ''], 'layer', '層級 欄位是必填的。');
        $this->assertValidationFails(['sort_order' => ''], 'sort_order', '排序權重 欄位是必填的。');
        $this->assertValidationFails(['is_active' => ''], 'is_active', '是否啟用 欄位是必填的。');
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
