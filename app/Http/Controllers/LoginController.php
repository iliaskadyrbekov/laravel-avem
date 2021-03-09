<?php

namespace App\Http\Controllers;

use App\Traits\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    use Follow;
    static $followingsAmount = 7;
    public function show(){
        $data = [
            'right_menu' => $this->rightMenuBuilder(self::$followingsAmount),
        ];
        return view('sign-in', $data);
    }

    public function authenticate(Request $request){
        $validator = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required|min:5'
        ]); // check if the data is valid, else return to the sign page with MessageBag
        $credentials = $request->only('email', 'password'); // extract data to check it
        if (Auth::attempt($credentials)) { // check in the DB
            // Authentication passed...
            return redirect()->intended('home'); // back to screen user tried to visit or home
        }
        return redirect()->back()->withErrors(new MessageBag(['password' => 'Wrong password.'])); // wrong password, back to sign page
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('home');
    }
}
