<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    use SoftDeletes;

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
