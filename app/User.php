<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false; // no created_at or updated_at
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'first_name', 'last_name', 'birth', 'city_id', 'profile_image', 'background_image', 'status', 'description', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];
    public function city(){
        return $this->belongsTo('App\City');
    }
    public function roles() {
        return $this->belongsToMany('App\Role');
    }

    public function blogs() {
        return $this->hasMany('App\Blog');
    }

    public function avems() {
        return $this->belongsToMany('App\Blog', 'avems');
    }

    public function bookmarks() {
        return $this->belongsToMany('App\Blog', 'bookmarks');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function followings(){ // who is followed - user
        return $this->belongsToMany('App\User', 'follower_following', 'follower_id', 'following_id');
    }
    // [user obj]->followings()->attach(User::find(7))  - user starts following the 7th
    /// [user obj]->followings()->detach(User::find(7))  - user unfollows the 7th

    public function followers(){ // who follows - subscriber
        return $this->belongsToMany('App\User', 'follower_following', 'following_id', 'follower_id');
    }
    // [user obj]->followers()->attach(User::find(15))  - add follower 15th to user
    /// [user obj]->followers()->detach(User::find(15))  - remove follower 15th from the user

}
