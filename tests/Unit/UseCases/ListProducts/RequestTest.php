<?php

namespace Tests\Unit\UseCases\ListProducts;

use Tests\TestCase;
use App\UseCases\ListProducts\Request;
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
        $this->assertArrayHasKey('description', $rules);
        $this->assertEquals('nullable|string', $rules['description']);
        $this->assertArrayHasKey('page', $rules);
        $this->assertEquals('nullable|integer|min:1', $rules['page']);
        $this->assertArrayHasKey('page_size', $rules);
        $this->assertEquals('nullable|integer|min:1|max:100', $rules['page_size']);
        $this->assertArrayHasKey('order_by', $rules);
        $this->assertEquals('nullable|string|in:id,name,description,price', $rules['order_by']);
        $this->assertArrayHasKey('order_direction', $rules);
        $this->assertEquals('nullable|string|in:asc,desc', $rules['order_direction']);
    }


    // 測試自定義錯誤訊息
    public function testCustomMessages()
    {
        $request = new Request();

        $expectedMessages = [
            'name.string' => '名稱 欄位必須是一個字串。',
            'description.string' => '描述 欄位必須是一個字串。',
            'page.integer' => '頁碼 欄位必須是一個整數。',
            'page.min' => [
                'array' => '頁碼 欄位必須至少有 1 個項目。',
                'file' => '頁碼 欄位必須至少為 1 KB。',
                'numeric' => '頁碼 欄位必須至少為 1。',
                'string' => '頁碼 欄位必須至少為 1 個字元。',
            ],
            'page_size.integer' => '每頁顯示數量 欄位必須是一個整數。',
            'page_size.min' => [
                'array' => '每頁顯示數量 欄位必須至少有 1 個項目。',
                'file' => '每頁顯示數量 欄位必須至少為 1 KB。',
                'numeric' => '每頁顯示數量 欄位必須至少為 1。',
                'string' => '每頁顯示數量 欄位必須至少為 1 個字元。',
            ],
            'page_size.max' => [
                'array' => '每頁顯示數量 欄位不得多於 100 個項目。',
                'file' => '每頁顯示數量 欄位不得大於 100 KB。',
                'numeric' => '每頁顯示數量 欄位不得大於 100。',
                'string' => '每頁顯示數量 欄位不得大於 100 個字元。',
            ],
            'order_by.string' => '排序欄位 欄位必須是一個字串。',
            'order_by.in' => '所選的 排序欄位 無效。',
            'order_direction.string' => '排序方向 欄位必須是一個字串。',
            'order_direction.in' => '所選的 排序方向 無效。',
        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    // 測試驗證通過情境
    public function testValidRequestPasses()
    {
        $request = new Request();
        $request->merge([
            'keyword' => 'Test Product',
            'page' => 1,
            'page_size' => 10,
            'order_by' => 'name',
            'order_direction' => 'asc',
        ]);

        $validator = Validator::make($request->all(), $request->rules());

        $this->assertFalse($validator->fails());
    }

    // 測試各種驗證失敗情境
    public function testValidationFailureScenarios()
    {
        $this->assertValidationFails(['page' => 'abc'], 'page', '頁碼 欄位必須是一個整數。');
        $this->assertValidationFails(['page' => 0], 'page', '頁碼 欄位必須至少為 1。');
        $this->assertValidationFails(['page_size' => 101], 'page_size', '每頁顯示數量 欄位不得大於 100。');
        $this->assertValidationFails(['page_size' => 0], 'page_size', '每頁顯示數量 欄位必須至少為 1。');
        $this->assertValidationFails(['page_size' => 'abc'], 'page_size', '每頁顯示數量 欄位必須是一個整數。');
        $this->assertValidationFails(['order_by' => 1], 'order_by', '排序欄位 欄位必須是一個字串。 所選的 排序欄位 無效。');
        $this->assertValidationFails(['order_direction' => 1], 'order_direction', '排序方向 欄位必須是一個字串。');
        $this->assertValidationFails(['order_direction' => 'abc'], 'order_direction', '所選的 排序方向 無效。');
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
