<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'Book';

    protected $fillable = ['judul', 'jumlah_halaman', 'penerbit', 'user_id'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
