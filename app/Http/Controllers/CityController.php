<?php

namespace App\Http\Controllers;

use App\Traits\Feed;
use App\Traits\Follow;
use Illuminate\Http\Request;
use App\City;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    use Follow;
    use Feed;
    static $followingsAmount = 7;
    static $blogsAmount = 15;

    public function show($city_id, $pages = 1) {
        if($pages <= 0) $pages = 1;
        Log::info('got city request');
        $city = City::find($city_id);
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'content' => $this->getCityFeed(self::$blogsAmount, $pages, $city),
            'highlights' => $this->getHighlights($city),
            'city' => $city
        ];
        Log::info('ready to load city, all data gained');
        return view('city1', $data);
    }

    public function getHighlights($city){
        return $city->places()->get();
    }
}
