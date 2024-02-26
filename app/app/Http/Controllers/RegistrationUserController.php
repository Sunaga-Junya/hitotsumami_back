<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationUserRequest;
use App\Services\RegistrationUserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationUserController extends Controller
{
    public function __construct(
        private RegistrationUserService $registrationUserService
    ) {
    }

    public function post(RegistrationUserRequest $request): JsonResponse
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        return response()->json($this->registrationUserService->registrationUser(
            $name,
            $email,
            $password
        ), Response::HTTP_CREATED);

    }
}
