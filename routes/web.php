<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register_page');
});

Route::post('/register-store', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);


Route::get('/add-ticket', function () {
    return view('add_ticket');
})->middleware('authcheck');

Route::post('/tickets-store', [LoginController::class, 'store'])->middleware('authcheck');
Route::get('/tickets-view', [LoginController::class, 'ticketView'])->middleware('authcheck');
Route::delete('/ticket-delete/{id}', [LoginController::class, 'delete'])->middleware('authcheck');

Route::get('/ticket-edit/{id}', [LoginController::class, 'edit'])->middleware('authcheck');
Route::post('/ticket-update/{id}', [LoginController::class, 'update'])->middleware('authcheck');

Route::get('/dashboard', [LoginController::class, 'ticketCounts'])->middleware('authcheck');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('authcheck');
Route::get('/view-users', [LoginController::class, 'userView'])->middleware('authcheck');

