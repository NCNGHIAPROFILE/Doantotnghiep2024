<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject 
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'id',
        'MaSV',
        'FistNameUser',
        'LastNameUser',
        'Class',
        'AddressUser',
        'Phone',
        'email',
        'password',
        'Token',
        'ImageUser',
        'role'
    ];
    public $timestamps = false;
    public function users() {
        return $this->belongsTo('App\Models\User');
    }

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Implement the JWTSubject interface methods
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($user) {
            $existingUser = self::where('MaSV', $user->MaSV)->orWhere('email', $user->email)->first();
            if ($existingUser) {
                return false;
            }
        });
    }
}
