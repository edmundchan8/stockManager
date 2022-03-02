<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DividendsController;
use App\Http\Controllers\StocksController;

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
Route::get('/dividends', [DividendsController::class, 'index'])->name('dividends');
//Route::post('/dividends', [DividendsController::class, 'store']);

//stocks
Route::get('/stocks', [stocksController::class, 'index'])->name('stocks');
Route::post('/stocks', [stocksController::class, 'store']);

//Route::post('/stocks', [stocksController::class, 'store']);

// login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/', function () {
    return view('index');
});
