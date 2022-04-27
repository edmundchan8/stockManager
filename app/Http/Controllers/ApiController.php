<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ApiController extends Controller
{
    public function index()
    {
        $ticker_stocks_array = ['AAPL', 'AMZN', 'APAM', 'BEP', 'CAH', 'COST', 'CRSP', 'EBET', 'FB', 'GOOG', 'HAS', 'HD', 'HOOD', 'JEPI', 'JNJ', 'JPM', 'LUMN', 'MSFT', 'NEE', 'NHI', 'O', 'PG', 'PLTR', 'SBUX', 'SCHD', 'TCEHY', 'TDOC', 'TSLA', 'VICI', 'WASH', 'BAT-USD', 'BTC-USD', 'ETH-USD', 'LINK-USD'];
        $stock_table_columns = ['symbol', 'fiftyDayAverage', 'twoHundredDayAverage', 'regularMarketPrice', 'regularMarketPreviousClose', 'forwardPE', 'trailingAnnualDividendRate', 'averageAnalystRating']
        ;

        $API_KEY = "x-api-key: ikpSY4wP1r9r3cNsFMsf12zFmHLDansa6rkkDzGz";

        $default_url = "https://yfapi.net/v7/finance/options/";

        // // This will ignore any ssl checks on the url, allowing the api call to go ahead
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // // attach header to request
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //loop through and get api data of each stock
        foreach($ticker_stocks_array as $stock){
            $stock_url = $default_url . $stock;

             // Initiate the curl request
            $ch = curl_init($stock_url);

            curl_setopt_array($ch, [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    $API_KEY
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
            
            $forwardPE = null;
            $trailingDivRate = null;
            $avgAnalystRating = null;

            isset($quote_array['forwardPE']) ? $forwardPE = $quote_array['forwardPE'] : '';
            isset($quote_array['trailingAnnualDividendRate']) ? $trailingDivRate = $quote_array['trailingAnnualDividendRate'] : '';
            isset($quote_array['averageAnalystRating']) ? $avgAnalystRating = $quote_array['averageAnalystRating'] : '';

            DB::table('stock_data')->insert([
                'symbol' => $quote_array['symbol'],
                'fiftyDayAverage' => $quote_array['fiftyDayAverage'],
                'twoHundredDayAverage' => $quote_array['twoHundredDayAverage'],
                'regularMarketPrice' => $quote_array['regularMarketPrice'],
                'regularMarketPreviousClose' => $quote_array['regularMarketPreviousClose'],
                'forwardPE' => $forwardPE,
                'trailingAnnualDividendRate' => $trailingDivRate,
                'averageAnalystRating' => $avgAnalystRating,
            ]);
            echo "symbol: " . $quote_array['symbol'] . "<br/>";
            echo "fiftyDayAverage: " . $quote_array['fiftyDayAverage'] . "<br/>";
            echo "twoHundredDayAverage: " . $quote_array['twoHundredDayAverage'] . "<br/>";
            echo "regularMarketPrice: " . $quote_array['regularMarketPrice'] . "<br/>";
            //echo "regularMarketDayHigh: " . $quote_array['regularMarketDayHigh'] . "<br/>";
            //echo "regularMarketDayLow: " . $quote_array['regularMarketDayLow'] . "<br/>";
            echo "regularMarketPreviousClose: " . $quote_array['regularMarketPreviousClose'] . "<br/>";
            echo "regularMarketOpen: " . $quote_array['regularMarketOpen'] . "<br/>";
            echo "forwardPE: " . $forwardPE . "<br/>";
            echo "trailingAnnualDividendRate: " . $trailingDivRate . "<br/>";
            echo "averageAnalystRating: " . $avgAnalystRating . "<br/><br/>";
        }
        return view('data.index');
    }
}