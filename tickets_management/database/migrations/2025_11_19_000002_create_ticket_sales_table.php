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
        Schema::create('ticket_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->string('buyer_name')->comment('買家名稱');
            $table->string('buyer_contact')->nullable()->comment('買家聯絡方式');
            $table->string('platform')->comment('售賣平臺 (如: 58.com、Xianyu 等)');
            $table->integer('quantity_sold')->comment('售賣數量');
            $table->decimal('unit_price', 10, 2)->comment('售賣單價');
            $table->decimal('total_revenue', 10, 2)->comment('總收入');
            $table->string('currency')->default('CNY')->comment('幣種');
            $table->string('sale_status')->default('pending')->comment('售賣狀態: pending, confirmed, shipped, completed');
            $table->string('shipping_address')->nullable()->comment('郵寄地址');
            $table->string('shipping_method')->nullable()->comment('郵寄方式 (如: 快遞、順豐 等)');
            $table->string('tracking_number')->nullable()->comment('物流單號');
            $table->date('sale_date')->nullable()->comment('售賣日期');
            $table->date('shipped_date')->nullable()->comment('發貨日期');
            $table->text('notes')->nullable()->comment('備註');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_sales');
    }
};
