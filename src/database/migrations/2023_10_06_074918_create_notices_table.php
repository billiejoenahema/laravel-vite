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
        Schema::create('notices', function (Blueprint $table) {
            $table->comment('お知らせ');

            $table->id();
            $table->string('title')->comment('タイトル');
            $table->text('content')->comment('内容');

            $table->softDeletes();
            $table->datetime('created_at')->nullable()->comment('登録日時');
            $table->datetime('updated_at')->nullable()->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
