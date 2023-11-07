<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    use HasFactory;
    protected $table = 'producers';
    protected $fillable = [
        'id',
        'MaNXB',
        'NameNXB',
        'AddressNXB',
        'Note',
    ];
    public $timestamps = false;
    public function producer() {
        return $this->belongsTo('App\Models\Producer');
    }
    public static function boot()
    {
        parent::boot();
        static::created(function($producers) {
            $producers->MaNXB .= 'PRO_' . str_pad($producers->id, 2, '0', STR_PAD_LEFT);
            $producers->save();
        });
    }
}
