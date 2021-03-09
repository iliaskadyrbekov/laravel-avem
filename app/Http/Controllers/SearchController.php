<?php

namespace App\Http\Controllers;

use App\Traits\Feed;
use App\Traits\Follow;
use App\Traits\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    use Search;
    use Follow;
    use Feed;
    static $followingsAmount = 7;
    static $blogsAmount = 15;

    public function show($search_parameter, $pages = 1) {
        if($pages <= 0) $pages = 1;
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'contents' => $this->getSearchedFeed(self::$blogsAmount, $pages, $search_parameter),
            'search_parameter' => $search_parameter
        ];
        return view('search', $data);
    }

    public function inputProcessSimple($string) {
        $input = preg_replace('/[\s++]/',' ', $string);
        $words = explode(',', $input);
        for($i = 0; $i < count($words); $i+=1) {
            $words[$i] = trim($words[$i], ' ');
        }
        return $words;
    }

    public function inputProcess($string) {
        $string = preg_replace('/[\s++]/',' ', $string);
        $input = preg_replace('/[&]/',',', $string);
        $words = explode(',', $input);
        $final = array();
        for($i = 0; $i < count($words); $i+=1) {
            $words[$i] = trim($words[$i], ' ');
            if(!empty($words[$i])) $final[] = $words[$i];
        }
        return $final;
    }

    public function locationResult(Request $request){
        if (!$request->ajax())
            return response()->json('');
        $words = $this->inputProcessSimple($request->input);
        $answers = '';
        switch (count($words)) {
            case 1: {
                $query = $this->findCountry("$words[0]%");
                if($query->count() == 1){ // if there is only one country with that name, add all it's cities
                    $names = $this->findCity("$words[0]%", "%")->get();
                    foreach ($names as $name){
                        $answers .= "<p>$name->country_name, $name->city_name</p>";
                    }
                }
                else {
                    $names = $query->get();
                    foreach ($names as $name){
                        $answers .= "<p>$name->country_name,</p>";
                    }
                }
                break;
            }
            case 2: {
                $query = $this->findCity("$words[0]", "$words[1]");
                if($query->count() == 0) {
                    $names = $this->findCity("$words[0]", "$words[1]%")->get();
                    foreach ($names as $name){
                        $answers .= "<p>$name->country_name, $name->city_name</p>";
                    }
                }
                break;
            }
        }
        return response()->json( $answers );
    }

    public function placeResult(Request $request){
        if (!$request->ajax())
            return response()->json('');
        $words = $this->inputProcessSimple($request->input);
        $answers = '';
        switch (count($words)) {
            case 1: {
                $query = $this->findCountry("$words[0]%");
                if($query->count() == 1){ // if there is only one country with that name, add all it's cities
                    $names = $this->findCity("$words[0]%", "%")->get();
                    foreach ($names as $name){
                        $answers .= "<p>$name->country_name, $name->city_name</p>";
                    }
                }
                else {
                    $names = $query->get();
                    foreach ($names as $name){
                        $answers .= "<p>$name->country_name,</p>";
                    }
                }
                break;
            }
            case 2: {
                $query = $this->findCity("$words[0]", "$words[1]");
                if($query->count() == 0) {
                    $names = $this->findCity("$words[0]", "$words[1]%")->get();
                    foreach ($names as $name){
                        $answers .= "<p>$name->country_name, $name->city_name</p>";
                    }
                }
                break;
            }
            case 3: {
                $query = $this->findPlace("$words[0]", "$words[1]", "$words[2]");
                if($query->count() == 0) {
                    $names = $this->findPlace("$words[0]", "$words[1]", "$words[2]%")->get();
                    foreach ($names as $name){
                        $answers .= "<p>$name->country_name, $name->city_name, $name->place_name</p>";
                    }
                }
                break;
            }
        }
        return response()->json( $answers );
    }
}
