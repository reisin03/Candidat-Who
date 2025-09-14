<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', 'is_user');
    }

    public function index()
    {
        return view('/user/home');
    }
}
