<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = [
        'id',
        'MaTicket',
        'MaSV',
        'MaSach',
        'MaAdmin',
        'DateCreateTicket',
        'DateAcceptTiket',
        'DateGiveBack',
        'StatusTicket',
        'Note',
    ];
    public $timestamps = false;
    public function ticket() {
        return $this->belongsTo('App\Models\Ticket');
    }
    public static function boot()
    {
        parent::boot();
        static::created(function($tickets) {
            $tickets->MaTicket .= 'TIC_' . str_pad($tickets->id, 2, '0', STR_PAD_LEFT);
            $tickets->save();
        });
    }
}
