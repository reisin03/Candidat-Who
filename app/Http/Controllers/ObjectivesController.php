<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObjectivesController extends Controller
{
    public function index()
    {
        //
    }

    public function show()
    {
        return view('objectives.show'); 
    }
}
