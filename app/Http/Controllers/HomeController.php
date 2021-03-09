<?php

namespace App\Http\Controllers;

use App\Traits\Follow;
use App\Traits\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller {
    use Follow;
    use Feed;
    static $followingsAmount = 7;
    static $blogsAmount = 15;

    public function show($pages = 1) {
        if($pages <= 0) $pages = 1;
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'contents' => $this->getFeed(self::$blogsAmount, $pages)
        ];
        return view('home', $data);
    }
}
