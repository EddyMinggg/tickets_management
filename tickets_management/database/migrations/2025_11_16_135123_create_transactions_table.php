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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->string('section')->comment('座位區域');
            $table->enum('type', ['purchase', 'sale'])->comment('交易類型');
            $table->integer('quantity')->comment('數量');
            $table->decimal('price', 10, 2)->comment('單價');
            $table->enum('currency', ['HKD', 'CNY'])->default('HKD')->comment('幣種');
            $table->decimal('exchange_rate', 10, 4)->comment('使用的匯率');
            $table->decimal('total_hkd', 10, 2)->comment('折合港幣總額');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
