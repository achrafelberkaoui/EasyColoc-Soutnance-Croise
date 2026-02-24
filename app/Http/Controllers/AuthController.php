<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function register(RegisterRequest $request)
    {
       $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
        if($user->id === 1){
            $user->is_admin = true;
            $user->save();
        }
    Auth::login($user);
    return redirect('/dashboard');
    }

    public function showLogin()
    {
    return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('password', 'email');
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            if($user->is_banned){
                Auth::logout();
                return back()->with('error', 'desole vous etes bloque');
            }
        return redirect()->intended('/dashboard');
        }
        return back()->with('error', 'Email ou mot de passe incorrect');
    }
        
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
