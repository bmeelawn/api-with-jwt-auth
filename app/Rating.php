<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * The attributes that are mass assigned
     */
    protected $fillable = ['user_id', 'book_id', 'rating'];

    /**
     * One rating belongs to only one book
     * @return $this->belongsTo
     */
    public function book() {
        return $this->belongsTo('App\Book', 'book_id', 'id');
    }
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
