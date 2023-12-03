<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'historys';
    protected $fillable = [
        'id',
        'MaSV',
        'MaSach',
        'DateDownload',
    ];
    public $timestamps = false;
    public function history() {
        return $this->belongsTo('App\Models\History');
    }
}
