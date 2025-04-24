<?php

namespace App\Libraries\RateLimiter;

use App\Libraries\RateLimiter\RateLimiterInterface;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class RateLimiter implements RateLimiterInterface
{
    protected string $key;
    protected int $maxAttempts;
    protected int $decaySeconds;

    public function __construct($key, $maxAttempts = 15, $decaySeconds = 60)
    {
        $this->key = $key;
        $this->maxAttempts = $maxAttempts;
        $this->decaySeconds = $decaySeconds;
    }

    public function attempt(): bool
    {
        $cacheKey = 'rate_limit:' . $this->key;
        $attempts = Cache::get($cacheKey, 0);

        if ($attempts >= $this->maxAttempts) {
            return false;
        }

        Cache::put($cacheKey, $attempts + 1, now()->addSeconds($this->decaySeconds));
        return true;
    }

    public function availableIn(): int
    {
        $cacheKey = 'rate_limit:' . $this->key;
        return Cache::getExpiration($cacheKey) - Carbon::now()->timestamp;
    }
}
