<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FillPDFController;

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
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/home', function () {
    return view('home');
});

// Route::get('/upload', function () {
//     return view('upload');
// });

Route::post('/process_certificate', [FillPDFController::class, 'process'])->name('process_certificate');
Route::get('/create_certificate', [FillPDFController::class, 'create'])->name('create_certificate');
Route::get('/document', function () {
    return view('document');
});

Route::get('/admin', [AdminController::class, 'index']);
