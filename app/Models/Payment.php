<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'reference_no',
        'total_amount',
        'payment_method_id',
        'status'
    ];


    /**
     * 
     * RELATIONSHIPS 
     * 
     */
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
