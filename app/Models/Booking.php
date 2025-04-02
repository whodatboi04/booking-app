<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'discount_id',
        'reference_no',
        'start_date',
        'end_date',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
