<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    //
    public $timestamps = false; // no created_at or updated_at
    protected $primaryKey = 'id';

    public function cities() {
        return $this->hasMany('App\City');
    }
}
