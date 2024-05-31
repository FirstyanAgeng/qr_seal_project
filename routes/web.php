<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FillPDFController;
use App\Http\Controllers\AuthController;
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

Route::get('/', [AuthController::class, 'showLoginForm'])->name('/');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);




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
