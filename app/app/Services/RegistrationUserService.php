<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationUserService
{
    /**
     * @return array{name: string, email: string}
     */
    public function registrationUser(
        string $name,
        string $email,
        string $password,
    ): array {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        return [
            'name' => $user->name,
            'email' => $user->email
        ];
    }
}
