<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $type = Auth::user()->user_type;   // ← use user_type
    
            Log::debug('[SHOW LOGIN FORM] Authenticated user_type = ' . $type);
            return match($type) {
                'admin'      => redirect()->route('admin.dashboard'),
                'instructor' => redirect()->route('instructor.dashboard'),
                default      => redirect()->route('student.dashboard'),
            };
        }
        Log::debug('[SHOW LOGIN FORM] not authenticated, showing login view');
    
        return view('index');
    }




    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $type = Auth::user()->user_type;
        
            $type = Auth::user()->user_type;
            Log::debug('[LOGIN REDIRECT] user_type = ' . $type);
        
            switch ($type) {
                case 'admin':
                    Log::debug('[LOGIN REDIRECT] going to admin');
                    return redirect()->route('admin.dashboard');
                case 'instructor':
                    Log::debug('[LOGIN REDIRECT] going to instructor');
                    return redirect()->route('instructor.dashboard');
                default:
                    Log::debug('[LOGIN REDIRECT] going to student');
                    return redirect()->route('student.dashboard');
            }
        }
        

        return back()->withErrors(['username' => 'Invalid credentials']);
    }


    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
