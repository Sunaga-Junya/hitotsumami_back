<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function post(Request $request){
        $data = $request->json()->all();
        Log::debug(var_export($data,true));
        Log::debug($data['email']);
        Log::debug($data['password']);
        
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            $token = Auth::user()->createToken('AccessToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else{
            return response(null, 401);
        }
    }
}
