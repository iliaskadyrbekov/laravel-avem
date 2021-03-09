<?php

namespace App\Http\Controllers;

use App\Traits\Feed;
use App\Traits\Follow;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    use Follow;
    use Feed;
    static $followingsAmount = 7;
    static $blogsAmount = 15;

    public function show($pages = 1) {
        if($pages <= 0) $pages = 1;
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'contents' => $this->getBookmarkedFeed(self::$blogsAmount, $pages)
        ];
        return view('bookmarks', $data);
    }
}
