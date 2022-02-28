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
        // then run a raw sql code, where you use selectRaw to run raw sql
        // and get the sum of the quantity, as quantity, then sum of quantitiy* price as each stocks total, followed by having the name of the stocks
        $yauyau_stocks = DB::table('yauyau_stocks')
            ->groupBy('name')
            ->selectRaw('SUM(quantity) as quantity, SUM(quantity*price) as total, name')
            ->get();
        return view('stocks.index', ['stocks' => $yauyau_stocks]);
    }
}
