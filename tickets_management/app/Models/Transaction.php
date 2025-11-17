<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'concert_date',
        'section',
        'type',
        'quantity',
        'price',
        'currency',
        'exchange_rate',
        'total_hkd',
    ];

    protected $casts = [
        'concert_date' => 'date',
        'price' => 'decimal:2',
        'exchange_rate' => 'decimal:4',
        'total_hkd' => 'decimal:2',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
