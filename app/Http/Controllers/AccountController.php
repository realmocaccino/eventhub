<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        return Inertia::render('Account/Index');
    }
}
