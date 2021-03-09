<?php

namespace App\Traits;

use App;
use App\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait Feed {

    public function getFeed($amount, $pages) {
        $blogs = Blog::orderByDesc('updated_at')->skip(0)->take($amount * $pages)->get();
        $hasMore = false;
        if(Blog::all()->count() > $amount * $pages){
            $hasMore = true;
        }
        return ['blogs' => $blogs,
                'pages' => $pages + 1,
                'hasMore' => $hasMore];
    }

    public function getUserFeed($amount, $pages, $user) {
        $blogs = $user->blogs()->orderByDesc('updated_at')->skip(0)->take($amount * $pages)->get();
        $hasMore = false;
        if($user->blogs->count() > $amount * $pages){
            $hasMore = true;
        }
        return ['blogs' => $blogs,
            'pages' => $pages + 1,
            'hasMore' => $hasMore];
    }

    public function getBookmarkedFeed($amount, $pages) {
        $blogs = auth()->user()->bookmarks()->skip(0)->take($amount * $pages)->get()->reverse();
        $hasMore = false;
        if(auth()->user()->blogs->count() > $amount * $pages){
            $hasMore = true;
        }
        return ['blogs' => $blogs,
            'pages' => $pages + 1,
            'hasMore' => $hasMore];
    }

    public function getCityFeed($amount, $pages, $city) {
        $blogs = $city->blogs()->orderByDesc('updated_at')->skip(0)->take($amount * $pages)->get();
        $hasMore = false;
        if($city->blogs->count() > $amount * $pages){
            $hasMore = true;
        }
        return ['blogs' => $blogs,
            'pages' => $pages + 1,
            'hasMore' => $hasMore];
    }

    public function getPlaceFeed($amount, $pages, $place) {
        $blogs = $place->blogs()->orderByDesc('updated_at')->skip(0)->take($amount * $pages)->get();
        $hasMore = false;
        if($place->blogs->count() > $amount * $pages){
            $hasMore = true;
        }
        return ['blogs' => $blogs,
            'pages' => $pages + 1,
            'hasMore' => $hasMore];
    }

    public function getSearchedFeed($amount, $pages, $search_parameter) {
        $words = $this->inputProcess($search_parameter);
        //Log::info($words);

        $location = array();
        switch (count($words)) {
            case 2: { // wants to get precise city
                $location = [
                    ['country_name', 'like', "$words[0]%"],
                    ['city_name', 'like', "$words[1]%"]
                ];
                $getBlogs = Blog::orderByDesc('updated_at')
                    ->leftJoin('cities', 'cities.id', '=', 'blogs.city_id')
                    ->leftJoin('countries', 'countries.id', '=', 'cities.country_id')
                    ->select('blogs.*')
                    ->where($location);
                break;
            }
            case 3: { // wants to get precise place
                $location = [
                    ['country_name', 'like', "$words[0]%"],
                    ['city_name', 'like', "$words[1]%"],
                    ['place_name', 'like', "$words[2]%"]
                ];
                $getBlogs = Blog::orderByDesc('updated_at')
                    ->leftJoin('places', 'places.id', '=', 'blogs.place_id')
                    ->leftJoin('cities', 'cities.id', '=', 'places.city_id')
                    ->leftJoin('countries', 'countries.id', '=', 'cities.country_id')
                    ->select('blogs.*')
                    ->where($location);
                break;
            }
            default: { // wants to get country/city/place, tag, user
                $sub_words = explode(' ', $words[0]);
                //Log::info($sub_words);
                $country = ['country_name', 'like', "$sub_words[0]%"];
                $city = ['city_name', 'like', "$sub_words[0]%"];
                $place = ['place_name', 'like', "$sub_words[0]%"];
                $tag = array();
                foreach ($sub_words as $sub_word)
                    $tag[] = ['tag_name', 'like', "$sub_word%"];
                //Log::info($tag);
                switch (count($sub_words)) {
                    case 2: { // wants to get user by full name
                        $first_name = ['first_name', 'like', "$sub_words[0]%"];
                        $last_name = ['last_name', 'like', "$sub_words[1]%"];
                        $getBlogs = Blog::orderByDesc('updated_at')
                            ->leftJoin('cities', 'cities.id', '=', 'blogs.city_id')
                            ->leftJoin('places', 'places.id', '=', 'blogs.place_id')
                            ->leftJoin('countries', 'countries.id', '=', 'cities.country_id')
                            ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                            ->select('blogs.*')
                            ->whereHas('tags', function($query) use($tag) {
                                $query->Where($tag);
                            })
                            ->orWhere([$country])
                            ->orWhere([$city])
                            ->orWhere([$place])
                            ->orWhere([$first_name, $last_name]);
                        break;
                    }
                    default: {
                        $first_name = ['first_name', 'like', "$sub_words[0]%"];
                        $last_name = ['last_name', 'like', "$sub_words[0]%"];
                        $getBlogs = Blog::orderByDesc('updated_at')
                            ->leftJoin('cities', 'cities.id', '=', 'blogs.city_id')
                            ->leftJoin('places', 'places.id', '=', 'blogs.place_id')
                            ->leftJoin('countries', 'countries.id', '=', 'cities.country_id')
                            ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                            ->select('blogs.*')
                            ->whereHas('tags', function($query) use($tag) {
                                $query->where([$tag[0]]);
                                foreach ($tag as $item)
                                    $query->orwhere([$item]);
                            })
                            ->orWhere([$country])
                            ->orWhere([$city])
                            ->orWhere([$place])
                            ->orWhere([$first_name])
                            ->orWhere([$last_name]);
                        break;
                    }
                }
            }
        }
        $blogs = $getBlogs->skip(0)->take($amount * $pages)->get();

        $hasMore = false;
        if($getBlogs->count() > $amount * $pages){
            $hasMore = true;
        }
        return ['blogs' => $blogs,
            'pages' => $pages + 1,
            'hasMore' => $hasMore];
    }
}
