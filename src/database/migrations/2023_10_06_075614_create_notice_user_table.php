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
        Schema::create('notice_user', function (Blueprint $table) {
            $table->comment('お知らせ既読');

            $table->id();
            $table->foreignId('user_id')->comment('ユーザーID')->index();
            $table->foreignId('notice_id')->comment('おしらせID')->index();
            $table->timestamp('read_at')->nullable()->comment('既読日時');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice_user');
    }
};
