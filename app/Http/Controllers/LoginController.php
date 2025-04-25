<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        // $email = $request->email;
        // $password = $request->password;
        $credential = $request->only('email', 'password');
        // Auth : class
        if (Auth::attempt($credential)) {
            $user = Auth::user();
            if ($user->role_id == 1) {
                return redirect('dashboard');
            } elseif ($user->role_id == 2) {
                return redirect('kasir');
            } 
                // return redirect('dashboard')->with('success', 'Success Login');
                return back()->withErrors(['email' => 'Please check your credentials'])->withInput();
            
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('login');
    }
}
