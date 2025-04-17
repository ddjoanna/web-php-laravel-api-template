<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    private array $errors = [];

    public function __construct(
        string $message = 'Invalid data',
        array $errors = [],
        int $code = 422
    ) {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    /**
     * 新增欄位錯誤訊息
     *
     * @param string $key 欄位名稱
     * @param string|string[] $message 錯誤訊息或錯誤訊息陣列
     */
    public function addError(string $key, $message): void
    {
        if (isset($this->errors[$key])) {
            // 如果已存在，合併錯誤訊息
            $existing = $this->errors[$key];
            if (is_array($existing)) {
                $this->errors[$key] = array_merge($existing, (array)$message);
            } else {
                $this->errors[$key] = array_merge([$existing], (array)$message);
            }
        } else {
            $this->errors[$key] = $message;
        }
    }

    /**
     * 取得所有錯誤訊息
     *
     * @return array<string, string|string[]>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
