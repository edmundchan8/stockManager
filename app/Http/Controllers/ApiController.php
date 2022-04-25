<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ApiController extends Controller
{
    public function index()
    {
        $headers = [
            "x-api-key: ikpSY4wP1r9r3cNsFMsf12zFmHLDansa6rkkDzGz"
        ];

        // Initiate the curl request
        $ch = curl_init("https://yfapi.net/v7/finance/options/AAPL");

        // // This will ignore any ssl checks on the url, allowing the api call to go ahead
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // // attach header to request
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://yfapi.net/v7/finance/options/AAPL",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-api-key: ikpSY4wP1r9r3cNsFMsf12zFmHLDansa6rkkDzGz"
            ],
        ]);

        // send the request and get a bool response from it
        $response = curl_exec($ch);

        //capture any errors if exec above fails
        $err = curl_error($ch);

        // close the session and free up resources
        curl_close($ch);

        if ($err){
            echo 'cURL Error #:' . $err;
        }
        else{
            $json = json_decode($response, true);
            $stock_data_array = $json['optionChain']['result'][0];
        }

        $quote_array = $stock_data_array['quote'];
        echo "symbol: " . $quote_array['symbol'] . "<br/>";
        echo "fiftyDayAverage: " . $quote_array['fiftyDayAverage'] . "<br/>";
        echo "twoHundredDayAverage: " . $quote_array['twoHundredDayAverage'] . "<br/>";
        echo "regularMarketPrice: " . $quote_array['regularMarketPrice'] . "<br/>";
        echo "regularMarketDayHigh: " . $quote_array['regularMarketDayHigh'] . "<br/>";
        echo "regularMarketDayLow: " . $quote_array['regularMarketDayLow'] . "<br/>";
        echo "regularMarketPreviousClose: " . $quote_array['regularMarketPreviousClose'] . "<br/>";
        echo "regularMarketOpen: " . $quote_array['regularMarketOpen'] . "<br/>";
        echo "forwardPE: " . $quote_array['forwardPE'] . "<br/>";
        echo "trailingAnnualDividendRate: " . $quote_array['trailingAnnualDividendRate'] . "<br/>";
        echo "averageAnalystRating: " . $quote_array['averageAnalystRating'] . "<br/>";

        // loop through all stocks I have
        // place data in json or spreadsheet

        return view('data.index');
    }
}