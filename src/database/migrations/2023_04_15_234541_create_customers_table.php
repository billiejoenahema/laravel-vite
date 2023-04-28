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
        Schema::create('customers', function (Blueprint $table) {
            $table->comment('顧客');

            $table->id();
            $table->foreignId('user_id')->nullable()->comment('ユーザーID')->index();
            $table->string('name')->nullable()->comment('氏名');
            $table->string('name_kana')->nullable()->comment('ふりがな');
            $table->string('phone')->nullable()->comment('電話番号');
            $table->char('gender', 2)->nullable()->comment('性別');
            $table->date('birth_date')->nullable()->comment('生年月日');
            $table->char('postal_code', 7)->nullable()->comment('郵便番号');
            $table->char('pref', 2)->nullable()->comment('都道府県');
            $table->string('city')->nullable()->comment('市区町村');
            $table->string('street')->nullable()->comment('番地');
            $table->string('avatar')->nullable()->comment('アイコン画像URL');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
