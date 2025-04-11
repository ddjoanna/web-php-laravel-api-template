<?php

namespace App\Interfaces;

interface ApiResponse
{
    /**
     * 設定回應的狀態。
     *
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void;

    /**
     * 設定回應的訊息。
     *
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void;

    /**
     * 設定回應的數據。
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data): void;

    /**
     * 將回應轉換為陣列格式。
     *
     * @return array
     */
    public function toArray(): array;
}
