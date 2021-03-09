<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model {
    public $timestamps = false; // no created_at or updated_at
    protected $primaryKey = 'id';

    public function users() {
        return $this->hasMany('App\User');
    }

    public function blogs() {
        return $this->hasMany('App\Blog');
    }

    public function country() {
        return $this->belongsTo('App\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
