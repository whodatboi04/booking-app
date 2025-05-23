<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    /** @use HasFactory<\Database\Factories\RoomTypeFactory> */
    use HasFactory;

    public function rooms(){
        return $this->hasMany(Room::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function scopeRoomTypesFilter($query, $filter){
        if(isset($filter['search'])){
            $query->searchFilter($filter);
        }

        return $query;
    }

    public function scopeSearchFilter($query, $filter){
        return $query->where('name', 'like', '%' . $filter['search'] . '%');
    }
}
