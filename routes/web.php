<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/home', [Dashboard::class,'index'])->name('dashboard.index');

//input
Route::get('/input', [Dashboard::class,'inputIndex']);
Route::post('/input/manual', [Dashboard::class,'inputDataSet']);

//pre
Route::get('/pre', [Dashboard::class,'preIndex']);
//tf-idf
Route::get('/tf-idf ', [Dashboard::class,'tfidfIndex']);
//nvb
Route::get('/nvb', [Dashboard::class,'nvbIndex']);
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
