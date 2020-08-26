<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('users', 'API\UserController@store');
Route::middleware('auth:api')->namespace('API')->group(static function () {
    Route::resource('users', 'UserController')->except(['store']);
    Route::get('wallets/{wallet}/transactions', 'WalletController@transactions');
    Route::post('wallets', 'WalletController@store');
    Route::get('wallets/{wallet}', 'WalletController@show');
    Route::post('transactions', 'TransactionController@store');
    Route::get('transactions', 'TransactionController@index');
});
