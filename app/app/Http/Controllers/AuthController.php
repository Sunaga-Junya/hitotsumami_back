<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\AuthPostRequest;

class AuthController extends Controller
{
    public function post(AuthPostRequest $request): Response
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $token = $request->user()->createToken($request['email'])->plainTextToken;
            return response()->json(['token' => $token], Response::HTTP_OK);
        } else {
            return response(null, Response::HTTP_UNAUTHORIZED);
        }
    }
}
