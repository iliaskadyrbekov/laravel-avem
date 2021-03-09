<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    public $timestamps = true; // no created_at or updated_at
    protected $primaryKey = 'id';

    public function blog() {
        return $this->belongsTo('App\Blog');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
