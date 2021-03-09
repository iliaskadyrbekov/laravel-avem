<?php

namespace App\Traits;

use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait Follow {

    public function startFollowing($user){
        if(!auth()->user()->followings->contains($user))
            return auth()->user()->followings()->attach($user);
        return 0;
    }

    public function stopFollowing($user){
        if(auth()->user()->followings->contains($user))
            return auth()->user()->followings()->detach($user);
        return 0;
    }

    public function getFollowers($user) {
        return $user->followers()->get();
    }

    public function getFollowings($user) {
        return $user->followings()->get();
    }

    public function rightMenuBuilder($amount){
        $people = [];
        $hasFollowings = false;
        if(auth()->check() and !is_null(auth()->user()->followings->first())) {
            $people = auth()->user()->followings->take($amount); // get people whom we follow [7 max]
            $hasFollowings = true;
        } else {
            $users = App\User::all();
            $ids = DB::table('follower_following')
                ->select('following_id')
                ->groupBy('following_id')
                ->orderByRaw('count(following_id) desc')
                ->pluck('following_id')->take($amount); // get array of most popular people ids [7 max]
            foreach ($ids as $value)
                $people[] = $users->find($value);
            $hasFollowings = false;
        }
        return ['people' => $people, 'hasFollowings' => $hasFollowings];
    }

    public function getSubscriptions($amount, $pages){
        $people = [];
        $hasFollowings = false;
        $hasMore = false;
        if(auth()->check() and !is_null(auth()->user()->followings->first())) {
            $people = auth()->user()->followings->take($amount * $pages); // get people whom we follow [7 max]
            $hasFollowings = true;
            if(auth()->user()->followings->count() > $amount * $pages){
                $hasMore = true;
            }
        } else {
            $users = App\User::all();
            $ids = DB::table('follower_following')
                ->select('following_id')
                ->groupBy('following_id')
                ->orderByRaw('count(following_id) desc')
                ->pluck('following_id')->take($amount * $pages); // get array of most popular people ids [7 max]
            foreach ($ids as $value)
                $people[] = $users->find($value);
            $hasFollowings = false;
            if($users->count() > $amount * $pages){
                $hasMore = true;
            }
        }
        return ['people' => $people,
            'hasFollowings' => $hasFollowings,
            'pages' => $pages + 1,
            'hasMore' => $hasMore];
    }
}
