<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\OperationController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/accounts{id?}', [AccountController::class, 'index'])->name('accounts');
Route::get('/operations{id?}', [OperationController::class, 'index'])->name('operations');
Route::get('/articles{id?}', [ArticleController::class, 'index'])->name('articles');
Route::get('/currencies{id?}', [CurrencyController::class, 'index'])->name('currencies');
Route::get('/reports', function () {
    return view('reports.reports');
})->middleware(['auth'])->name('reports');

require __DIR__.'/auth.php';
