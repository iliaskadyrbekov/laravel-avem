<?php
namespace App\Http\Controllers;

use App\Traits\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App;

class UserController extends Controller {
    use Follow;
    static $followingsAmount = 7;
    static $subsAmount = 25;

    public function show($pages = 1) {
        if($pages <= 0) $pages = 1;
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'contents' => $this->getSubscriptions(self::$subsAmount, $pages)
        ];
        return view('subscriptions', $data);
    }

    public function follow($user_id){
        //Log::info(auth()->user()->id.' follow '.$user_id);
        $this->startFollowing(App\User::find($user_id));
        return redirect()->back();
    }
    public function unfollow($user_id){
        //Log::info(auth()->user()->id.' unfollow '.$user_id);
        $this->stopFollowing(App\User::find($user_id));
        return redirect()->back();
    }
    public function like(Request $request){
        $blog = App\Blog::find($request->blog_id);
        if(auth()->user()->avems->contains($blog)){
            auth()->user()->avems()->detach($blog);
            $data['like'] = false; //which icon to show
        }
        else {
            auth()->user()->avems()->attach($blog);
            $data['like'] = true; //which icon to show
        }
        $data['like_amount'] = $blog->avems()->count(); //new amount
        return response()->json($data);
    }
    public function bookmark(Request $request){
        $blog = App\Blog::find($request->blog_id);
        if(auth()->user()->bookmarks->contains($blog)){
            auth()->user()->bookmarks()->detach($blog);
            $data['bookmark'] = false; //which icon to show
        }
        else {
            auth()->user()->bookmarks()->attach($blog);
            $data['bookmark'] = true; //which icon to show
        }
        return response()->json($data);
    }
}

// use it for between user interaction (subs ...)
