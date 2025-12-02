<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function scopePaymentMethodFilters($query, $filters)
    {
        if (isset($filters['search'])) {
            return $query->searchFilter($filters);
        }

        if (isset($filters['status'])) {
            return $query->statusFilter($filters);
        }

        return $query;
    }

    public function scopeSearchFilter($query, $filters)
    {
        return $query->where('name', 'LIKE', '%' . $filters['search'] . '%');
    }

    public function scopeStatusFilter($query, $filters)
    {
        return $query->where('status', $filters['status']);
    }


    /**
     * 
     * RELATIONSHIPS 
     * 
     */

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
