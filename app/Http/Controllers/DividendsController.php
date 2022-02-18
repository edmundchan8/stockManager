<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DividendsController extends Controller
{
    public function index()
    {
        return view('dividends/index');
    }
}
