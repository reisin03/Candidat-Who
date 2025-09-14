<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        // Apply the 'auth:admin' and 'is_admin' middleware to all methods in this controller
        $this->middleware(['auth:admin', 'is_admin']);
    }

    public function index()
    {
        return view('admin.home'); // or 'admin/home' depending on your view folder
    }
}
