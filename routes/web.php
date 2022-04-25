<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DividendsController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//dividends
// each route has a controller and a method name you want to use
//        '/the url route   [controlller::class        , method]   -> the laravel route helper name, in the view, you use {{'name of this route'}}
Route::get('/dividends', [DividendsController::class, 'index'])->name('dividends');
Route::get('/filterDividends', [DividendsController::class, 'filter'])->name('filterDividends');
// this is the post method of the save /dividends route.  No need for laravel route helper name
Route::post('/dividends', [DividendsController::class, 'store']);
Route::get('/dividends/{stockName}', [DividendsController::class, 'show']);

//stocks
Route::get('/stocks', [StocksController::class, 'index'])->name('stocks');
Route::post('/stocks', [StocksController::class, 'store']);
Route::get('/stocks/{stockName}', [StocksController::class, 'show']);

// login
// Route::get('/login', [LoginController::class, 'index'])->name('login');
// Route::post('/login', [LoginController::class, 'store']);

// API to stocks
Route::get('/data', [ApiController::class, 'index'])->name('data');

Route::get('/', function () {
    return view('index');
});
