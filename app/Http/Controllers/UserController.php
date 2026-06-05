<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        return view('user');
    }

    public function show(string $id)
    {
        return view('user', compact('id'));
    }

    public function profile(string $username, string $email)
    {
        return view('user', compact('username', 'email'));
    }
}
