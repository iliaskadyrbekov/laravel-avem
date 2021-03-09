<?php

namespace App\Http\Controllers;

use App;
use App\Traits\Follow;
use App\Traits\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    use Follow;
    use Feed;
    static $followingsAmount = 7;
    static $blogsAmount = 15;

    public function show($user_id, $pages = 1) {
        if($pages <= 0) $pages = 1;
        $profile_owner = App\User::find($user_id);
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'contents' => $this->getUserFeed(self::$blogsAmount, $pages, $profile_owner),
            'profile_owner' => $profile_owner,
            'visited' => $this->getVisited($profile_owner),
        ];
        return view('profile', $data);
    }
    public function getVisited($profile_owner){
        $visited = $profile_owner->blogs()
            ->join('places', 'places.id', '=', 'blogs.place_id')
            ->select('places.*')->distinct()
            ->get();
        //Log::info($visited);
        return $visited;
    }
}
