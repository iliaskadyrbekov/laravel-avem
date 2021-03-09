<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    public $timestamps = false; // no created_at or updated_at
    protected $primaryKey = 'id';

    protected $fillable = [
        'role_name'
    ];
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
