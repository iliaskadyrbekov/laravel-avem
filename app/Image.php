<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
    public $timestamps = false; // no created_at or updated_at
    protected $primaryKey = 'id';

    public function blog() {
        return $this->belongsTo('App\Blog');
    }
}
