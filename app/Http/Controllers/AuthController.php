<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{
    //la page qui permet d'afficher le formulaire de l'authentification
    public function auth(){
            return view("auth.login");
    }
    

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function showRegisterForm(){
        return view("auth.register");
    }
     public function register(Request $request){

        $validation = $request->validate([
            'name' => ['required'],
            'phone' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'zip' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        User::create(
        $validation
        );
        return redirect()->route('login');
        
    }
}
