<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'User';

    protected $fillable = ['nama', 'umur'];

    public function book() {
        return $this->hasMany('App\Book', 'user_id', 'id');
    }
}
