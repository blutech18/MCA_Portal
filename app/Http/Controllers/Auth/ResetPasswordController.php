<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; 

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }
    protected function redirectTo()
    {
        return route('password.reset.success');
    }

    /**
     * Reset the given user's password without logging them in.
     *
     * @param  \App\Models\User   $user      The Eloquent user instance
     * @param  string             $password  The new password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();
    }
}
