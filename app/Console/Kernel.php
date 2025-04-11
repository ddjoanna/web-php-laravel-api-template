<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * 應用程式的 Artisan 命令
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\MakeService::class,
        \App\Console\Commands\MakeRepository::class,
        \App\Console\Commands\MakeUseCase::class,
    ];

    /**
     * 定義 Artisan 排程
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {}

    /**
     * 註冊 Artisan 命令
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
