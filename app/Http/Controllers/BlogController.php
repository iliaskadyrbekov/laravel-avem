<?php
namespace App\Http\Controllers;

use App\Rules\Location;
use App\Rules\TagRule;
use App\Rules\PhotoRule;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\Follow;
use App\Traits\Search;
use App;
use App\Blog;
use App\Tag;
use App\User;
use App\Place;
use App\City;
use App\Image;
use App\Comment;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class BlogController extends Controller {
    use Follow;
    use Search;
    static $followingsAmount = 7;
    static $commentsAmount = 100;

    public function addBlog() {
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
        ];
        return view('/add-blog', $data);
    }

    public function show($blog_id, $pages = 1) {
        if($pages <= 0) $pages = 1;
        $blog = Blog::find($blog_id);
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'content' => $this->getCommentFeed(self::$commentsAmount, $pages, $blog),
            'blog' => $blog
        ];
        return view('blog', $data);
    }

    public function getCommentFeed($amount, $pages, $blog) {
        $comments = $blog->comments()->orderByDesc('created_at')->skip(0)->take($amount * $pages)->get();
        $hasMore = false;
        if($blog->comments->count() > $amount * $pages){
            $hasMore = true;
        }
        return ['comments' => $comments,
            'pages' => $pages + 1,
            'hasMore' => $hasMore];
    }


    public function addComment(Request $request,$blog_id, $pages = 1) {
        $user = Auth::user();
        $validator = $request->validate([
            'comment_text' => 'required|min:2|max:1000',
        ]);

        $comment = new Comment();
        $comment->comment_text = $request->input('comment_text');
        $blog = Blog::find($blog_id) ;
        $comment->user()->associate($user);
        $comment->blog()->associate($blog);
        $comment->save();
        return redirect()->route('blog',$blog_id)->with('success', 'Message updated');
    }


    public function saveBlog(Request $request) {
        $user = Auth::user();
        $validator = $request->validate([
            "photo"    => ['required', new PhotoRule],
            'location' => ['required', new Location],
            'blog_text' => 'required|min:2|max:1700',
            "tag"    => ['required', new TagRule],
        ]);

        $blog = new Blog();
        $blog->blog_text = $request->input('blog_text');
        $blog->user()->associate($user);

        $location = explode(', ', $request->location); // get country and city
        if(count($location) == 2){// Ukraine, Abrikosovka
            $city_id = $this->findCityId("$location[0]", "$location[1]")->first()->id;
            $city = City::find($city_id);
            $city->blogs()->save($blog);

        } elseif (count($location) == 3){ // Ukraine, Abrikosovka, Place
            $city_id = $this->findCityId("$location[0]", "$location[1]")->first()->id;
            $city = City::find($city_id);
            $city->blogs()->save($blog);
            $place_id = $this->findPlaceId("$location[0]", "$location[1]", "$location[2]")->first()->id;
            $place = Place::find($place_id);
            $place->blogs()->save($blog);
        }

//        TAGS
        $tagsFromInput = $request->input('tag');
        foreach ($tagsFromInput as $tagFromInput) {
            if(strlen($tagFromInput) < 2){
                continue;
            }
            $tag = Tag::where('tag_name', 'like', $tagFromInput)->first();
            if ($tag !== null) {
                $tag->blogs()->save($blog);
            }else{
                $tag = new Tag;
                $tag->tag_name = str_replace('#', '', $tagFromInput);
                $tag->save();
                $tag->blogs()->attach($blog->id);
            }

        }

        foreach ($request->photo as $photo) {
            $image = new Image;
            $imageType = $photo->getClientOriginalExtension();
            $imageStr = (string) ImageIntervention::make( $photo )->
            resize( 1200, null, function ( $constraint ) {
                $constraint->aspectRatio();
            })->encode( $imageType );
            $image->image = base64_encode( $imageStr );
            $blog->images()->save($image);
            $image->save();
        }
        return redirect()->route('home')->with('success', 'Message updated');
    }
}
