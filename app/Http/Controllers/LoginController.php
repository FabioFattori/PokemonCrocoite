<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Box;
use App\Models\Position;
use App\Models\Team;
use App\Models\User;
use ErrorException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index(){
        return Inertia::render('Login', ['mode'=>'login']);
    }

    public function tryLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:255',
            'mode' => 'required|in:admin,login'
        ]);
        $credentials = $request->only('email', 'password');
        if (auth($request->mode === 'admin'? 'admin':'web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home.get');
        }
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.log');
    }

    public function register(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:255',
        ]);

        $randomPos = Position::all()->random();

        $user = User::create([
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'position_id' => $randomPos->id,
        ]);

        Team::create([
            'user_id' => $user->id,
            'date' => now(),
        ]);

        

        Box::create([
            'user_id' => $user->id,
            'name' => 'Box di '.explode('@',$user->email)[0],
        ]);

        //login user
        auth()->login($user);

        return redirect()->route('home.get');
    }

    public function registerAdmin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:255',
        ]);

        $user = Admin::create([
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        //login user
        auth("admin")->login($user);

        return redirect()->route('home.get');
    }

    

    public function admin(){
        return Inertia::render('Login', ['mode'=>'admin']);
    }
}
