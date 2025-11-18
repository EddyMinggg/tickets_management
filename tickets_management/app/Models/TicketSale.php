<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'buyer_name',
        'buyer_contact',
        'platform',
        'quantity_sold',
        'unit_price',
        'total_revenue',
        'currency',
        'sale_status',
        'shipping_address',
        'shipping_method',
        'tracking_number',
        'sale_date',
        'shipped_date',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'sale_date' => 'date',
        'shipped_date' => 'date',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->sale_status) {
            'pending' => '待確認',
            'confirmed' => '已確認',
            'shipped' => '已發貨',
            'completed' => '已完成',
            default => $this->sale_status,
        };
    }
}
