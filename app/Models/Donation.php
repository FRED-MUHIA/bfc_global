<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donation_type',
        'designation',
        'event_name',
        'amount',
        'currency',
        'frequency',
        'donor_name',
        'email',
        'phone',
        'message',
        'paypal_order_id',
        'paypal_payer_id',
        'status',
    ];
}
