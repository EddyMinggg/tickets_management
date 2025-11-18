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
        Schema::create('ticket_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->string('seller_name')->comment('賣家名稱/平臺');
            $table->string('seller_contact')->nullable()->comment('賣家聯絡方式');
            $table->string('platform')->comment('購入平臺 (如: 蝦皮、Carousell 等)');
            $table->integer('quantity_purchased')->comment('購入數量');
            $table->decimal('unit_price', 10, 2)->comment('單位價格');
            $table->decimal('total_cost', 10, 2)->comment('總成本');
            $table->string('currency')->default('HKD')->comment('幣種');
            $table->text('notes')->nullable()->comment('備註');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_sources');
    }
};
