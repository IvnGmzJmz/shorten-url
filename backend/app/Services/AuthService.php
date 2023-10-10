<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function validateRegister(Request $request){
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    }

    public function validateLogin(Request $request) {
        return $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);
    }

    public function createToken(User $user){
        return $user->createToken('short-url-token')->plainTextToken;
    }

    public function generateToken($credentials){
        if (Auth::attempt($credentials)){
            return $this->createToken(Auth::user());
        }
        return null;
    }

    public function deleteToken(User $user){
        $user->tokens()->delete();
    }

}