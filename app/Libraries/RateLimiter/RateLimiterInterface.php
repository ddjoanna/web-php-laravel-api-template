<?php

namespace App\Libraries\RateLimiter;

interface RateLimiterInterface
{
    /**
     * 嘗試增加請求計數，超過限制回傳 false。
     */
    public function attempt(): bool;

    /**
     * 取得剩餘可用秒數。
     */
    public function availableIn(): int;
}
