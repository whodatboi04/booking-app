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

    public function scopeGiftCertFilter($query, $filters)
    {
        if (isset($filters['search'])) {
            return $query->searchFilter($filters);
        }

        if (isset($filters['date'])) {
            return $query->dateFilter($filters);
        }
    }

    public function scopeSearchFilter($query, $filters)
    {
        return $query->where('name', 'LIKE', '%' . $filters['search'] . '%')
            ->orWhereHas('room_type', function ($queryRoomType) use ($filters) {
                $queryRoomType->where('name', 'LIKE', '%' . $filters['search'] . '%');
            });
    }

    public function scopeDateFilter($query, $filters)
    {
        return $query->whereBetween('created_at', [
            $filters['date'] . ' 00:00:00',
            $filters['date'] . '  23:59:59'
        ]);
    }

    /**
     * 
     * RELATIONSHIPS 
     * 
     */

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_gift_certificate')->withTimestamps();
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }
}
