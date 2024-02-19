<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\AuthPostRequest;

class AuthController extends Controller
{
    public function post(AuthPostRequest $request){
        
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            $token = Auth::user()->createToken('AccessToken')->plainTextToken;
            return response()->json(['token' => $token], Response::HTTP_OK);
        } else{
            return response(null, Response::HTTP_UNAUTHORIZED);
        }
    }
}
