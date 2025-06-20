<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'room_type_id',
        'discount_id',
        'reference_no',
        'number_of_persons',
        'start_date',
        'end_date',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function room_type(){
        return $this->belongsTo(RoomType::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
