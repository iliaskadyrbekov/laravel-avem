<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
    public $timestamps = false; // no created_at or updated_at
    protected $primaryKey = 'id';

    public function blogs() {
        return $this->belongsToMany('App\Blog');
    }

}
