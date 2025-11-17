<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'concert_date',
        'section',
        'purchase_price',
        'quantity',
        'sold_quantity',
        'exchange_rate',
        'commission',
    ];

    protected $casts = [
        'concert_date' => 'date',
        'purchase_price' => 'decimal:2',
        'exchange_rate' => 'decimal:4',
        'commission' => 'decimal:2',
    ];

    /**
     * 計算剩餘數量
     */
    public function getRemainingQuantityAttribute()
    {
        return $this->quantity - $this->sold_quantity;
    }

    /**
     * 計算總購入價格
     */
    public function getTotalPurchasePriceAttribute()
    {
        return $this->purchase_price * $this->quantity;
    }

    /**
     * 計算總賣出價格（人民幣）
     */
    public function getTotalSoldPriceAttribute()
    {
        return $this->purchase_price * $this->sold_quantity * $this->exchange_rate;
    }
}
