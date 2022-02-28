<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StocksController extends Controller
{
    public function index()
    {
        //$yauyau_stocks = DB::select('select * from yauyau_stocks');
        //$yauyau_stocks = DB::table('yauyau_stocks')->get();
     
        // group total stocks by name
        // then run a raw sql code, where you side 
        $yauyau_stocks = DB::table('yauyau_stocks')
            ->groupBy('name')
            ->selectRaw('SUM(quantity) as quantity, name')
            ->get();
            
        return view('stocks.index', ['stocks' => $yauyau_stocks]);
    }
}
