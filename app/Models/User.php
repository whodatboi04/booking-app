<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Permission\v1\Abilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        $abilities = Abilities::getPermissions($this);
        return [
            'abilities' => $abilities,
            'roles' => $this->roles->pluck('name')->toArray()
        ];
    }

    public function scopeUserFilter($query, $filters)
    {
        if (isset($filters['search'])) {
            return $query->userSearch($filters);
        }

        if (isset($filters['status'])) {
            return $query->statusFilter($filters);
        }
        if (isset($filters['role'])) {
            return $query->roleFilter($filters);
        }
        return $query;
    }

    public function scopeUserSearch($query, $filters)
    {
        return $query->where('username', 'LIKE', '%' . $filters['search'] . '%')
            ->orWhere('email', 'LIKE', '%' . $filters['search'] . '%')
            ->orWhereHas('user_info', function ($queryUserInfo) use ($filters) {
                $queryUserInfo->where('firstname', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $filters['search'] . '%');
            });
    }

    public function scopeStatusFilter($query, $filters)
    {
        return $query->where('status', $filters['status']);
    }

    public function scopeRoleFilter($query, $filters)
    {
        return $query->whereHas('roles', function ($queryRole) use ($filters) {
            $queryRole->where('id', $filters['role']);
        });
    }

    /**
     *
     * RELATIONSHIPS
     *
     */

    //User Information Relationship
    public function user_info()
    {
        return $this->hasOne(UserInfo::class);
    }

    //Role Relationship
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role')->withTimestamps();
    }

    //Booking Relationship
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    //User Gift Certificate Relationship
    public function gift_certificate()
    {
        return $this->belongsToMany(GiftCertificate::class, 'user_gift_certificate')->withTimestamps();
    }

    //Check User Permission
    public function hasPermission($permission)
    {
        $userAbilities = Abilities::getPermissions($this);
        return in_array($permission,  $userAbilities) ? true : false;
    }
}
