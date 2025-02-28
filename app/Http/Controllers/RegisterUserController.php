<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function store() {
        // 'confirmed' matches the 'field' with 'field_confirmation' by convention
        $attributes = request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'max:254'],
            'password' => ['required', Password::min(5)->max(10), 'confirmed'] // password_confirmation field
        ]);

        $user = User::create($attributes);

        Auth::login($user);

        return redirect(('jobs'));
    }
}
