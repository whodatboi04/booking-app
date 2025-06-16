<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftCertificate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'room_type_id',
        'name',
        'description',
        'price',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * 
     * RELATIONSHIPS 
     * 
     */
    
    public function user(){
        return $this->belongsToMany(User::class, 'user_gift_certificate')->withTimestamps();
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }
}
