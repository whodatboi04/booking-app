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

    public function scopeBookingFilter($query, $filters)
    {
        if (isset($filters['status'])) {
            $query->statusFilter($filters);
        }
        if (isset($filters['search'])) {
            $query->searchFilter($filters);
        }
        if (isset($filters['start_date_from']) || isset($filters['start_date_to'])) {
            $query->startDateRangeFilter($filters);
        }
        if (isset($filters['end_date_from']) || isset($filters['end_date_to'])) {
            $query->endDateRangeFilter($filters);
        }

        return $query;
    }

    public function scopeStatusFilter($query, $filters) {
        return $query->where('status', $filters['status']);
    }

    public function scopeSearchFilter($query, $filters) {
        return $query->where('reference_no', 'LIKE', '%' . $filters['search'] . '%')
            ->orWhere('firstname', 'LIKE', '%' . $filters['search'] . '%')
            ->orWhere('lastname', 'LIKE', '%' . $filters['search'] . '%');
    }

    public function scopeStartDateRangeFilter($query, $filters) {
        if (!empty($filters['start_date_from']) && !empty($filters['start_date_to'])) {
            $query->whereBetween('start_date', [$filters['start_date_from'], $filters['start_date_to']]);
        }

        if(empty($filters['start_date_from'])) {
            $query->where('start_date', $filters['start_date_to']);
        }

        if(empty($filters['start_date_to'])) {
            $query->where('start_date', $filters['start_date_from']);
        }

        return $query;
    }

    public function scopeEndDateRangeFilter($query, $filters) {
        if (!empty($filters['end_date_from']) && !empty($filters['end_date_to'])) {
            $query->whereBetween('end_date', [$filters['end_date_from'], $filters['end_date_to']]);
        }

        if(empty($filters['end_date_from'])) {
            $query->where('end_date', $filters['end_date_to']);
        }

        if(empty($filters['end_date_to'])) {
            $query->where('end_date', $filters['end_date_from']);
        }

        return $query;
    }


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
