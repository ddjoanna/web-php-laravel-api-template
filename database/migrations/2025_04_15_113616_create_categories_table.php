<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('分類名稱');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('上層分類 ID');
            $table->unsignedInteger('layer')->default(0)->comment('層級');
            $table->integer('sort_order')->default(0)->comment('排序權重');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
