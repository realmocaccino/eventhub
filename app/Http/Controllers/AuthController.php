<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showRegistrationForm()
    {
        return Inertia::render('Auth/Register');
    }

    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function register(RegisterRequest $request)
    {
        $this->authService->registerUser($request->validated());
        
        return redirect()->route('events.index');
    }

    public function login(LoginRequest $request)
    {
        if ($this->authService->attemptLogin(
            $request->only('email', 'password'),
            $request->filled('remember')
        )) {
            $request->session()->regenerate();
            
            return redirect()->route('events.index');
        }

        return back()->withErrors([
            'message' => __('Invalid credentials'),
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}