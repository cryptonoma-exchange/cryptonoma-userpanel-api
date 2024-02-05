<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/verify/{email}', 'EmailVerifyController@sendEmailDone')->name('sendEmailDone');

Route::get('/tradingchart/{coinone}/{cointwo}', 'ChartController@tradingchart');
Route::get('/marketchart/{coinone}/{cointwo}', 'ChartController@MarketDepthChart');
Route::get('/marketdepthvalue/{coinone}/{cointwo}', 'ChartController@MarketDepthValue');
Route::get('/marketdepthchart/{pair}', 'ChartController@marketdepthData');

//chart
Route::get('/config', 'TradingViewChartServerController@config');
Route::get('/time', 'TradingViewChartServerController@time');
Route::get('/symbols', 'TradingViewChartServerController@symbols');
Route::get('/symbol_info', 'TradingViewChartServerController@symbol_info');
Route::get('/history', 'TradingViewChartServerController@history');
Route::get('/marks', 'TradingViewChartServerController@marks');
Route::get('/timescale_marks', 'TradingViewChartServerController@timescale_marks');
// Route::get('tradetest', 'TradingViewChartServerController@vvchart');
Route::get('exchangemarketdepthchart/{id}', 'HomeController@exchangemarketdepthchart');

// Route::get('/create-table', 'TableController@operate');
