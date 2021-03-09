<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\Traits\Follow;
use App\Rules\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\Input;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class EditProfileController extends Controller
{
    use Follow;
    static $followingsAmount = 7;

    public function show($user_id){
        $user = App\User::findOrFail($user_id);
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
            'user' => $user,
        ];
        return view('profile-edit', $data);
    }

    public function edit(Request $request,$user_id){
        $validator = $request->validate([
            'first_name' => 'alpha|required',
            'last_name' => 'nullable|alpha',
            'status' => 'nullable|max:100',
            'description' => 'nullable|max:200',
            'location' => ['required', new Location] //using custom rule to check location in DB
            ]); // check if the data is valid, else return to the sign page with MessageBag
        $user = App\User::findOrFail($user_id);
        if ( $request->location != null ) {
            $location = explode(', ', $request->location); // get country and city
            $city_id = DB::table('countries')
                ->join('cities', 'cities.country_id', '=', 'countries.id')
                ->select('cities.id')
                ->where('country_name', 'like', "$location[0]")
                ->where('city_name', 'like', "$location[1]")
                ->distinct()->first()->id; // get city id
            $user->city_id = $city_id;
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->status = $request->status;
        $user->description = $request->description;
        if (!is_null($request->profile_image)) {
            $imageProfType = $request->profile_image->getClientOriginalExtension();
            $imageStrProf = (string) ImageIntervention::make( $request->profile_image )->
            resize( 350, null, function ( $constraint ) {
                $constraint->aspectRatio();
            })->encode( $imageProfType );
            $user->profile_image = base64_encode($imageStrProf);
        }
        if (!is_null($request->background_image)) {
            $imageBgType = $request->background_image->getClientOriginalExtension();
            $imageStrBg = (string) ImageIntervention::make( $request->background_image )->
            resize( 1200, null, function ( $constraint ) {
                $constraint->aspectRatio();
            })->encode( $imageBgType );
            $user->background_image = base64_encode( $imageStrBg );
        }
        $user = $user->save(); // store to DB and get stored instance
        return redirect('/profile/'.$user_id);
    }
}
