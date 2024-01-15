<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\AuthPostRequest;

class AuthController extends Controller
{
    public function post(AuthPostRequest $request){
        
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            $token = Auth::user()->createToken('AccessToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else{
            return response(null, 401);
        }
    }
}
