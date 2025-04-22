<?php

namespace App\DTOs;

use App\Http\Requests\LoginRequest;

class LoginDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember = false
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            remember: $data['remember'] ?? false
        );
    }

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password'),
            remember: $request->boolean('remember'),
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'remember' => $this->remember,
        ];
    }
}