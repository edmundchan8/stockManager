<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DividendsController extends Controller
{
    public function index()
    {
        $dividends = DB::table('dividends')
            ->groupBy('name')
            ->selectRaw('SUM(amount) as amount, name')
            ->get();
        return view('dividends.index', ['dividends' => $dividends]);
    }

    public function filter()
    {
        $dividends = DB::table('dividends')
            ->selectRaw('
            EXTRACT(year FROM date) as year,
            EXTRACT(month FROM date) as month,
             name, amount
             ')
            ->get();

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

        // $dividends = DB::table('dividends')
        //     ->groupBy('name')
        //     ->selectRaw('SUM(amount) as amount, name')
        //     ->get();

        return view('dividends.filterDividends') //, ['dividends' => $dividends, 'year' => $years]);
            ->with('dividends', $dividends)
            ->with('years', json_encode($years))
            ->with('yearsTotal', json_encode($yearsTotal));
    }

    public function store(Request $request){

        // Form validation
        $validated = $request->validate([
            'stockName' => 'required',
            'amount' => 'required',
            'tickerSymbol' => 'required',
            'date'=>'required'
        ]);

        $name = $request->stockName;
        $tickerSymbol = $request->tickerSymbol;
        $amount = $request->amount;
        $date = $request->date;
        
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
}
