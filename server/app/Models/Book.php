<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $fillable = [
        'id',
        'MaSach',
        'NameBook',
        'Author',
        'MaAdmin',
        'Category',
        'Type',
        'MaProducer',
        'YearPublish',
        'Quantity',
        'Content',
        'Status',
        'Picture',
        'Sum_Quantity',
    ];
    public $timestamps = false;
    public function book() {
        return $this->belongsTo('App\Models\Book');
    }
    public static function boot()
    {
        parent::boot();
        static::created(function($books) {
            $books->MaSach .= 'BOK_' . str_pad($books->id, 2, '0', STR_PAD_LEFT);
            $books->save();
        });
    }
}
