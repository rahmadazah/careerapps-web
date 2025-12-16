<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengelolaTipekerja extends Controller
{
    public function index()
    {
        return view('tipekerja');
    }
}
