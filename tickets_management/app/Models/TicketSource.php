<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'seller_name',
        'seller_contact',
        'platform',
        'quantity_purchased',
        'unit_price',
        'total_cost',
        'currency',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
