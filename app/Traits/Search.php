<?php

namespace App\Traits;

use App;
use App\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait Search {

    public function findCountry($country) {
        return DB::table('countries')
            ->select('country_name')
            ->where('country_name', 'like', $country);
    }
    public function findCity($country, $city) {
        return DB::table('countries')
            ->join('cities', 'cities.country_id', '=', 'countries.id')
            ->select('country_name', 'city_name')
            ->where([
                ['country_name', 'like', $country],
                ['city_name', 'like', $city]
            ])->distinct();
    }
    public function findPlace($country, $city, $place) {
        return DB::table('countries')
            ->join('cities', 'cities.country_id', '=', 'countries.id')
            ->join('places', 'places.city_id', '=', 'cities.id')
            ->select('country_name', 'city_name', 'place_name')
            ->where([
                ['country_name', 'like', $country],
                ['city_name', 'like', $city],
                ['place_name', 'like', $place]
            ]);
    }

    public function findCountryId($country) {
        return DB::table('countries')
            ->select( 'countries.id')
            ->where('country_name', 'like', $country);
    }
    public function findCityId($country, $city) {
        return DB::table('countries')
            ->join('cities', 'cities.country_id', '=', 'countries.id')
            ->select( 'cities.id')
            ->where([
                ['country_name', 'like', $country],
                ['city_name', 'like', $city]
            ])->distinct();
    }
    public function findPlaceId($country, $city, $place) {
        return DB::table('countries')
            ->join('cities', 'cities.country_id', '=', 'countries.id')
            ->join('places', 'places.city_id', '=', 'cities.id')
            ->select('places.id')
            ->where([
                ['country_name', 'like', $country],
                ['city_name', 'like', $city],
                ['place_name', 'like', $place]
            ]);
    }
}
