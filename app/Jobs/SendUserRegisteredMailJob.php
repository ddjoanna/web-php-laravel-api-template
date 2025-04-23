<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Entities\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisteredMail;

class SendUserRegisteredMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // 最大執行時間(必須小於horizontal 設定的 retry_after 值，避免 Job 重複執行)
    public $timeout = 120;
    // 最多嘗試次數(若沒設定會無限重試)
    public $tries = 3;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;

        // 指定此 Job 要放入的佇列名稱（Queueable 提供）
        $this->onQueue('emails');

        // 指定延遲時間，例如 10 秒後執行（Queueable 提供）
        $this->delay(now()->addSeconds(10));
    }

    public function handle()
    {
        Log::info('SendUserRegisteredMailJob executed for user id: ' . $this->user->getId());

        try {
            // 執行任務
            Mail::to($this->user->getProps()->getEmail())
                ->send(new UserRegisteredMail($this->user));

            // 如果成功，刪除 Job（InteractsWithQueue 提供）
            $this->delete();
        } catch (\Exception $e) {
            Log::error('SendUserRegisteredMailJob failed: ' . $e->getMessage());

            // 發生錯誤，釋放 Job 回佇列，3 秒後重試（InteractsWithQueue 提供）
            $this->release(3);
        }
    }
}
