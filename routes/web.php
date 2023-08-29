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
Route::get('/pre', [Dashboard::class,'preprocessing']);
//tf-idf
Route::get('/tf-idf ', [Dashboard::class,'tfidf']);
//datauji
Route::get('/input ', [Dashboard::class,'inputDataUji']);
Route::post('/test_input ', [Dashboard::class,'testDdatUji']);
//nvb
Route::get('/nvb', [Dashboard::class,'nvb']);
Route::get('/nvb_delete/{id}', [Dashboard::class,'nvbDelete']);
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
