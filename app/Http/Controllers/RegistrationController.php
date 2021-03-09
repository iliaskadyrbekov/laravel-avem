<?php

namespace App\Http\Controllers;

use App;
use App\Rules\Location;
use App\Traits\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    use Follow;
    static $followingsAmount = 7;
    public function show(){
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
        ];
        return view('sign-up', $data);
    }

    public function register(Request $request){
        $validator = $request->validate([
            'first_name' => 'alpha|required',
            'last_name' => 'nullable|alpha',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:5',
            'birth' => 'nullable',
            'location' => ['required', new Location] //using custom rule to check location in DB
            ]); // check if the data is valid, else return to the sign page with MessageBag
        $user = new App\User; // instance to store data to the DB
        $location = explode(', ', $request->location); // get country and city
        $city_id = DB::table('countries')
            ->join('cities', 'cities.country_id', '=', 'countries.id')
            ->select('cities.id')
            ->where('country_name', 'like', "$location[0]")
            ->where('city_name', 'like', "$location[1]")
            ->distinct()->first()->id; // get city id
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth' => $request->birth,
            'city_id' => $city_id
        ]; // prepared data to store into user

        $user = $user->create($data); // store to DB and get stored instance
        $user->roles()->attach(App\Role::where('role_name', 'like', 'user')->first()->id); // make role_user
        Auth::login($user); // authorize user
        return redirect()->intended('home');
    }

}
