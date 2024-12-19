<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
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


/* route auth login */
Route::middleware('isNotLogin')->group(function () {
    Route::get('/', function () {return view('dashboard');})->name('dashboard');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/auth', [AuthController::class, 'authLogin'])->name('login.auth');
});


/* route auth logout */
Route::middleware('isLogin')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/report/create', [ReportController::class, 'createReport'])->name('report_create');
    Route::post('/report/store', [ReportController::class, 'storeReport'])->name('report_store');
    Route::get('/report/{id}', [ReportController::class, 'deleteReport'])->name('report_delete');
    Route::get('/report/me/show', [ReportController::class, 'reportMe'])->name('report_me');
    Route::get('/report/comment/{reportId}', [ReportController::class, 'comment'])->name('report_comment');
    Route::post('/report/comment/{reportId}', [ReportController::class, 'storeComment'])->name('comment_store');
});
