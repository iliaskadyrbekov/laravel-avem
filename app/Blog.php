<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model {
    protected $primaryKey = 'id';

    public function images() {
        return $this->hasMany('App\Image');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function place() {
        return $this->belongsTo('App\Place');
    }

    public function city() {
        return $this->belongsTo('App\City');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }

    public function avems() {
        return $this->belongsToMany('App\User', 'avems');
    }

    public function bookmarks() {
        return $this->belongsToMany('App\User', 'bookmarks');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }
}
