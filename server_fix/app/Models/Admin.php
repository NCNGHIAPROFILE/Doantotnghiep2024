<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';
    protected $fillable = [
        'id',
        'MaAdmin',
        'NameAdmin',
        'AddressAdmin',
        'Phone',
        'email',
        'password',
        'Token',
        'ImageAdmin',
        'role'
    ];
    public $timestamps = false;
    public function admin() {
        return $this->belongsTo('App\Models\Admin');
    }
    public static function boot()
    {
        parent::boot();
        static::created(function($admins) {
            $admins->MaAdmin .= 'ADM_' . str_pad($admins->id, 2, '0', STR_PAD_LEFT);
            $admins->save();
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
