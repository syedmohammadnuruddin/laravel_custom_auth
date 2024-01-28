<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(){
        return view("register");
    }

    public function registerPost(Request $request){

        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        // $user->save();
        // return back()->with('success', 'Register Successfully');
        
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'password'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]) ;   
        return back()->with('success', 'Register Successfully'); 
    }

    public function login(){
        return view("login");
    }

    public function loginPost(Request $request){
        $credentials = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if(Auth::attempt($credentials)){
            return redirect()->route('home')->with('success', 'Login Successful');
        }else{
            return back()->with('error','Wrong Email or Password');
        }
    }

    public function home(){
        return view('home');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
