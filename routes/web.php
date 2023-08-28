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
Route::get('/data_latih', [Dashboard::class,'inputIndex']);
Route::get('/data_latih_delete/{id}', [Dashboard::class,'deleteDataset']);
Route::post('/data_latih/input', [Dashboard::class,'inputDataSet']);
Route::get('/data_latih/train', [Dashboard::class,'inputDataSetTrain']);

//pre
Route::get('/pre', [Dashboard::class,'preIndex']);
//tf-idf
Route::get('/tf-idf ', [Dashboard::class,'tfidfIndex']);
//nvb
Route::get('/nvb', [Dashboard::class,'nvbIndex']);
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
