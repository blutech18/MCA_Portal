<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            else if ($user->role === 'instructor') {
                return redirect()->route('instructor.dashboard');
            } 
            else {
                return redirect()->route('student.dashboard');
            }
        }
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
            
            $user = Auth::user();
         
            if ($user->username === 'admin_mca') {
                return redirect()->route('admin.dashboard');
            }
            else if ($user->user_type === 'faculty') {
                return redirect()->route('instructor.dashboard');
            }
            else {
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
