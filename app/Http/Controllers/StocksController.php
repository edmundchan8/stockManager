<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class StocksController extends Controller
{
    public function index()
    {
        //$stocks = DB::select('select * from stocks');
        //$stocks = DB::table('stocks')->get();
     
        // group total stocks by name
        // then run a raw sql code, where you use selectRaw to run raw sql
        // and get the sum of the quantity, as quantity, then sum of quantitiy* price as each stocks total, followed by having the name of the stocks
        
        $last_stock_added = DB::table('stocks')
            ->latest('date')
            ->first();
        
        $stocks = DB::table('stocks')
            ->groupBy('name')
            ->selectRaw('SUM(quantity) as quantity, SUM(quantity*price) as total, MIN(owner) as owner, name')
            ->get();

        return view('stocks.index')
            ->with('stocks', $stocks)
            ->with('lastStock', $last_stock_added);
    }

    public function store(Request $request){

        // Form validation
        $validated = $request->validate([
            'stockName' => 'required',
            'buyOrSell' => 'required',
            'stockPrice'=>'required',
            'stockQty' => 'required',
            'owner' => 'required'
        ]);

        $name = $request->stockName;
        $tickerSymbol = $request->tickerSymbol;
        $buyOrSell = $request->buyOrSell;
        $price = $request->stockPrice;
        $quantity = $request->stockQty;
        $owner = $request->owner;
        $message = "Your stock was successfully added!";
        if ($request->date == null){
            $date = date("Y-m-d");
        }
        else{
            $date = $request->date;
        }

        if ($buyOrSell == 'sell'){
            $quantity *= -1;
            $message = "Your stock was successfully removed!";
        }
        
        // add stock to database
        DB::table('stocks')->insert(
            ['name' => $name, 'tickerSymbol' => $tickerSymbol, 'buySell'=> $buyOrSell, 'price' => $price, 'quantity' => $quantity, 'date' => $date, 'owner' => $owner]
        );
        // if validations work, redirect to previous page (index page)
        // have a section called 'success', that when is 'has' on the view blade, will show a notification that says the form submission was successful
        return back()->with('success', $message);
        // if validation didn't work, we should return an error, like e.g.
        // return Redirect::to('stocks/index')->with('message', 'Failed to Add Stock');
    }

    public function show($stockName){
        $stock = DB::table('stocks')
            ->where('name', '=', $stockName)
            ->get();

         $total = DB::table('stocks')
            ->where('name', '=', $stockName)
            ->sum(DB::raw('price * quantity'));

        //dd($total);

        return view('stocks.stockView')
        ->with('name', $stockName)
        ->with('total', $total)
        ->with('stock', $stock);
    }
}