<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'room_type_id',
        'discount_id',
        'reference_no',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'number_of_persons',
        'start_date',
        'end_date',
        'discount_id_picture',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
