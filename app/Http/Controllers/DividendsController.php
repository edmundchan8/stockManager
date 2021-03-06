<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Collection;

class DividendsController extends Controller
{
    public function index(Request $request)
    {
        $dividends = DB::table('dividends')
            ->groupBy('name')
            ->selectRaw('SUM(amount) as amount, name')
            ->get();
        
        $collection = collect(
            $dividends
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

        // Getting the last dividend added to the database
        $lastDividend = DB::table('dividends')
            ->latest('date')
            ->first();
        
        return view('dividends.index')
        ->with('dividends', $sorted)
        ->with('lastDiv', $lastDividend);
    }

    // filter Dividends
    public function filter(Request $request)
    {
        $query = DB::table('dividends')
            ->selectRaw('
            EXTRACT(year FROM date) as year,
            EXTRACT(month FROM date) as month,
             name, amount
             ');
        if ($request->name != null){
            $query = $query->where('name', '=', $request->name);
        }
        if ($request->tickerSymbol != null){
            $query = $query->where('tickerSymbol', '=', $request->tickerSymbol);
        }
        $dividends = $query->get();

        //dd($request->name);

        /** SETTING THE YEARLY DATA  */
        //array to hold each unique year
        $years = [];
        $yearsTotal = [];

        // foreach calculation to find each unique year
        foreach ($dividends as $dividend){
            if(!in_array($dividend->year, $years)){
                array_push($years, $dividend->year);
            }
        }

        //creating the JSON for yearsTotal to use later
        foreach($years as $year){
            $yearsTotal += array($year => 0);
        }

        //foreach calculation to sum up total dividends per year using
        // the $yearsTotal json created earlier

        foreach($dividends as $key=>$value){
            $year = $value->year;
            $amount = $value->amount;
            $yearsTotal[$year] += $amount;
        }

        /** SETTING THE MONTHLY DATA  */
        //array to hold each unique year
        $months = [];
        $monthsTotal = [];

        // foreach calculation to find each unique year
        foreach ($dividends as $dividend){
            $monYea = $dividend->month . "-" . $dividend->year;
            if(!in_array($monYea, $months)){
                array_push($months, $monYea);
            }
        }

        //creating the JSON for monthsTotal to use later
        foreach($months as $monYea){
            $monthsTotal += array($monYea => 0);
        }

        //foreach calculation to sum up total dividends per month using
        // the $monthsTotal json created earlier

        foreach($dividends as $key=>$value){
            $monYea = $value->month . "-" . $value->year;
            $amount = $value->amount;
            $monthsTotal[$monYea] += $amount;
        }

        /** Dividend data for last 12 months */
        $previous_year_date = date("Y-m-d", strtotime("-1 year"));
        $lastTwelveMonths = DB::table('dividends')
            ->select('amount')
            ->where('date','>=', $previous_year_date)
            ->sum('amount');

        return view('dividends.filterDividends') //, ['dividends' => $dividends, 'year' => $years]);
            ->with('dividends', $dividends)
            ->with('years', json_encode($years))
            ->with('yearsTotal', json_encode($yearsTotal))
            ->with('months', json_encode($months))
            ->with('monthsTotal', json_encode($monthsTotal))
            ->with('lastTwelveMonths', json_encode((float)$lastTwelveMonths));
    }

    public function store(Request $request){

        // Form validation
        $validated = $request->validate([
            'stockName' => 'required',
            'amount' => 'required',
            'tickerSymbol' => 'required'
        ]);

        $name = $request->stockName;
        $tickerSymbol = $request->tickerSymbol;
        $amount = $request->amount;
        if ($request->date == null){
            $date = date("Y-m-d");
        }
        else{
            $date = $request->date;
        }

        // add stock to database
        DB::table('dividends')->insert(
            ['name' => $name, 
            'tickerSymbol' => $tickerSymbol, 
            'amount' => $amount, 
            'date' => $date]
        );
        // if validations work, redirect to previous page (index page)
        // have a section called 'success', that when is 'has' on the view blade, will show a notification that says the form submission was successful
        return back()->with('success', 'Your dividend was successfully added!');
    }

    public function show($stockName){
        $stock = DB::table('dividends')
        ->where('name', '=', $stockName)
        ->get();

        return view('dividends.dividendView')
        ->with('name', $stockName)
        ->with('stock', $stock);
    }
}
