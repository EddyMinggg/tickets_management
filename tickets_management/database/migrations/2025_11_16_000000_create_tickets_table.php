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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->dateTime('purchase_date')->comment('購入時間');
            $table->decimal('purchase_price', 10, 2)->comment('購入價格');
            $table->integer('quantity')->comment('購入數量');
            $table->integer('sold_quantity')->default(0)->comment('賣出數量');
            $table->decimal('exchange_rate', 10, 4)->default(1)->comment('人民幣兌換價格');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
