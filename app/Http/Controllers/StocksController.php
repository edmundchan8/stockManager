<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;

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

    public function store(Request $request){

        // Form validation
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'buyOrSell' => 'required',
            'price'=>'required',
            'quantity' => 'required'
        ]);

        $name = $request->stockName;
        $tickerSymbol = $request->tickerSymbol;
        $buyOrSell = $request->buyOrSell;
        $price = $request->stockPrice;
        $quantity = $request->stockQty;
        $date = $request->date;
        
        // add stock to database
        DB::table('yauyau_stocks')->insert(
            ['name' => $name, 'tickerSymbol' => $tickerSymbol, 'buySell'=> $buyOrSell, 'price' => $price, 'quantity' => $quantity, 'date' => $date]
        );
        // if validations work, redirect to previous page (index page)
        // have a section called 'success', that when is 'has' on the view blade, will show a notification that says the form submission was successful
        return back()->with('success', 'Your stock was successfully added!');
        // if validation didn't work, we should return an error, like e.g.
        // return Redirect::to('stocks/index')->with('message', 'Failed to Add Stock');
    }
}
