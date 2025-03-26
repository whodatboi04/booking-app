<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'phone',
        'birthdate',
        'profile_picture'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
