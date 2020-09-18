<?php

use App\Http\Controllers\LineController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('line_login');
});

Route::get('/line-login', [LineController::class, 'lineLogin'])->name('line_login');
Route::get('/verify', [LineController::class, 'verify'])->name('line_verify');
Route::get('/auth', [LineController::class, 'getAccessToken'])->name('line_token');

Route::match(['get', 'post'], '/webhook', [LineController::class, 'webhook'])->name('line_messaging_api_webhook');



