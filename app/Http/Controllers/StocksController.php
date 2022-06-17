<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Collection;

class StocksController extends Controller
{
    public function index(Request $request)
    {
        // group total stocks by name
        // then run a raw sql code, where you use selectRaw to run raw sql
        // and get the sum of the quantity, as quantity, then sum of quantitiy* price as each stocks total, followed by having the name of the stocks

        $last_stock_added = DB::table('stocks')
            ->latest('date')
            ->first();            

        $stocks = DB::table('stocks')
            ->leftJoin('stock_data', 'stocks.tickerSymbol', '=', 'stock_data.tickerSymbol')
            //->select('name', 'quantity', 'owner' ,'stocks.tickerSymbol', 'regularMarketPrice')
            ->groupBy('name')
            ->selectRaw('SUM(quantity) as quantity, SUM(quantity*price) as investmentTotal, SUM(quantity*regularMarketPrice) as currentTotal,  MIN(owner) as owner, MIN(regularMarketPrice) as regMarPrice, 
            MIN(averageAnalystRating) as avgAnlRat, MIN(averageAnalystOpinion) as avgAnlOpn, name')
            ->get();

        $collection = collect(
            $stocks
        );

        $sortByName = "name";
        if (isset($request->sortBy)){
            $sortByName = $request->sortBy;
            $sorted = $collection->sortBy($sortByName);
        }
        else if (isset($request->sortByDesc)){
            $sortByName = $request->sortByDesc;
            $sorted = $collection->sortByDesc($sortByName);
        }
        else{
            $sorted = $collection->sortBy($sortByName);
        }
        
       
        return view('stocks.index')
            ->with('stocks', $sorted)
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

    public function update(Request $request){
        // Form validation
        $validated = $request->validate([
            'stockName' => 'required',
            'buyOrSell' => 'required',
            'stockPrice'=>'required',
            'stockQty' => 'required',
            'date' => 'required',
            'owner' => 'required'
        ]);

        // find the stock to update
        $stock = DB::table('stocks')->find($request->id);

        $name = $request->stockName;
        $tickerSymbol = $request->tickerSymbol;
        $buyOrSell = $request->buyOrSell;
        $price = $request->stockPrice;
        $quantity = $request->stockQty;
        $owner = $request->owner;
        $date = $request->date;
        $message = "Your stock was successfully updated!";

        // add stock to database
        DB::table('stocks')
        ->where('id', $request->id)
        ->limit(1)
        ->update(['name' => $name, 'tickerSymbol' => $tickerSymbol, 'buySell'=> $buyOrSell, 'price' => $price, 'quantity' => $quantity, 'date' => $date, 'owner' => $owner]
        );
        // if validations work, redirect to previous page (index page)
        // have a section called 'success', that when is 'has' on the view blade, will show a notification that says the form submission was successful
        return redirect('stocks')
            ->with('success', $message);
    }

    public function show($stockName){
        dump($stockName);
        $stock = DB::table('stocks')
            ->where('stocks.name', '=', $stockName)
            ->orderBy('date')
            ->get();

        $stockData = DB::table('stock_data')
        ->where('stock_data.tickerSymbol', '=', $stock[0]->tickerSymbol)
        ->get();

        $total = DB::table('stocks')
            ->where('name', '=', $stockName)
            ->sum(DB::raw('price * quantity'));

        return view('stocks.stockView')
        ->with('name', $stockName)
        ->with('total', $total)
        ->with('stock', $stock)
        ->with('data', $stockData[0]);
    }

    public function showOwner($owner){

        $stocks = DB::table('stocks')
            ->leftJoin('stock_data', 'stocks.tickerSymbol', '=', 'stock_data.tickerSymbol')
            ->groupBy('name')
            ->where('owner', '=', $owner)
            ->selectRaw('SUM(quantity) as quantity, SUM(quantity*price) as investmentTotal, SUM(quantity*regularMarketPrice) as currentTotal, MIN(owner) as owner, MIN(regularMarketPrice) as regMarPrice, 
            MIN(averageAnalystRating) as avgAnlRat, MIN(averageAnalystOpinion) as avgAnlOpn, name')
            ->get();

        $last_stock_added = DB::table('stocks')
            ->latest('date')
            ->first();

        $collection = collect(
            $stocks
        );
        
        $sorted = $collection->sortBy('name');    
        
        return view('stocks.index')
        ->with('stocks', $stocks)
        ->with('lastStock', $last_stock_added);
    }

    public function showOwnerStock($stockName, $owner){
        $stock = DB::table('stocks')
            ->where('stocks.name', '=', $stockName)
            ->where('owner','=',$owner)
            ->orderBy('date')
            ->get();

        $stockData = DB::table('stock_data')
        ->where('stock_data.tickerSymbol', '=', $stock[0]->tickerSymbol)
        ->get();

        $total = DB::table('stocks')
        ->where('name', '=', $stockName)
        ->where('owner','=',$owner)
        ->sum(DB::raw('price * quantity'));

        return view('stocks.stockView')
        ->with('name', $stockName)
        ->with('total', $total)
        ->with('data', $stockData[0])
        ->with('stock', $stock);
    }

    public function edit(Request $request){
        $stock = DB::table('stocks')->find($request->id);
        //dd($stock);
        return view('stocks.edit')
        ->with('stock', $stock);
    }
}