<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assigned
     */
    protected $fillable = ['user_id', 'title', 'description'];

    /**
     * Book can belongs to only one user
     * @return $this->belongsTo
     */
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function ratings() {
        return $this->hasMany('App\Rating', 'book_id', 'id');
    }
}
