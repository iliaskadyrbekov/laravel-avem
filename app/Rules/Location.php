<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Location implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $location = explode(', ', $value);
        if(count($location) == 2){// Ukraine, Abrikosovka
            $query = DB::table('countries')
                ->join('cities', 'cities.country_id', '=', 'countries.id')
                ->select('cities.id')
                ->where('country_name', 'like', "$location[0]")
                ->where('city_name', 'like', "$location[1]")
                ->distinct()->exists(); // true or false
            //Log::info($query);
            return $query;
        }

        if (count($location) == 3) { // Ukraine, Abrikosovka, Place
            $query = DB::table('countries')
                ->join('cities', 'cities.country_id', '=', 'countries.id')
                ->join('places', 'places.city_id', '=', 'cities.id')
                ->select('places.id')
                ->where('country_name', 'like', "$location[0]")
                ->where('city_name', 'like', "$location[1]")
                ->where('place_name', 'like', "$location[2]")
                ->distinct()->exists(); // true or false
            //Log::info($query);
            return $query;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return "This location doesn't exist!";
    }
}
