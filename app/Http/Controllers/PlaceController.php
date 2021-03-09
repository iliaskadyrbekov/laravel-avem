<?php

namespace App\Http\Controllers;

use App\Traits\Feed;
use App\Traits\Follow;
use Illuminate\Http\Request;
use App\Place;
class PlaceController extends Controller
{
    use Follow;
    use Feed;
    static $followingsAmount = 7;
    static $blogsAmount = 15;

    public function show($place_id, $pages = 1) {
        if($pages <= 0) $pages = 1;
        $place = Place::find($place_id);
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'content' => $this->getPlaceFeed(self::$blogsAmount, $pages, $place),
            'place' => $place,
            'weekArr' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
        ];
        return view('place1', $data);
    }
}
