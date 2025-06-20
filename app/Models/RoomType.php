<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    /** @use HasFactory<\Database\Factories\RoomTypeFactory> */
    use HasFactory;
    
    protected $fillable = [
        'name',
        'price',
        'available_slot'
    ];
   

    public function scopeRoomTypesFilter($query, $filter){
        if(isset($filter['search'])){
            $query->searchFilter($filter);
        }

        if (isset($filter['persons'])) {
            $query->filterByPersons($filter);
        }

        return $query;
    }

    public function scopeSearchFilter($query, $filter){
        return $query->where('name', 'like', '%' . $filter['search'] . '%');
    }

    public function scopeFilterByPersons($query, $filter) 
    {
        $query->where('room_capacity', '>=', $filter['persons']);
    }
    

    /**
     * 
     * RELATIONSHUPS 
     * 
     */

     public function gift_certificate()
     {
         return $this->hasMany(GiftCertificate::class);
     }

     public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
