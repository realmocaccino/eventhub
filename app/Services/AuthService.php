<?php

namespace App\Services;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function registerUser(RegisterDTO $data): void
    {
        $user = $this->userRepository->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        Auth::login($user);
    }

    public function attemptLogin(LoginDTO $data): bool
    {
        return Auth::attempt(
            [
                'email' => $data->email,
                'password' => $data->password
            ],
            $data->remember
        );
    }

    public function logout(): void
    {
        Auth::logout();
    }
}