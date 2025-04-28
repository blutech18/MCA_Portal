<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();             // or paginate/filter as needed
        return view('admin_users', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'username'              => 'required|string|unique:users,username',
            'password'              => 'required|string|min:6|confirmed',
            'user_type'             => 'required|in:student,faculty',
        ]);

        User::create([
            'name'      => $validated['name'],
            'username'  => $validated['username'],
            'password'  => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
        ]);

        return redirect()->back()->with('success', 'User successfully added!');

    }

}
