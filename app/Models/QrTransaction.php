<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrTransaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tx_id',
        'buyer_id',
        'vendor_id',
        'order_id',
        'amount',
        'commission_amount',
        'vendor_amount',
        'status',
        'expires_at'
    ];
}

