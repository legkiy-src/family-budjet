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

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/operations{id?}', [OperationController::class, 'index'])->name('operations');
//Route::get('/articles{id?}', [ArticleController::class, 'index'])->name('articles');
//Route::get('/currencies{id?}', [CurrencyController::class, 'index'])->name('currencies');
Route::get('/reports', function () {
    return view('reports.reports');
})->middleware(['auth'])->name('reports');

Route::group(['middleware' => ['auth']], function () {

    /*Route::get('/', function () {
        return redirect('/accounts');
    });*/

    Route::group(['prefix' => "accounts"],function() {
        Route::get('/', [AccountController::class, 'index'])->name('accounts');
        Route::group(['as' => "accounts."], function() {
            Route::any('create', [AccountController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => '{id}', 'as' => "accounts."],function() {
            Route::match(['get', 'post'], '/edit', [AccountController::class, 'edit'])->name('edit');
            Route::get('/delete', [AccountController::class, 'delete'])->name('delete');
        });
    });

    Route::group(['prefix' => "currencies"],function() {
        Route::get('/', [CurrencyController::class, 'index'])->name('currencies');
        Route::group(['as' => "currencies."], function() {
            Route::any('create', [CurrencyController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => '{id}', 'as' => "currencies."],function() {
            Route::match(['get', 'post'], '/edit', [CurrencyController::class, 'edit'])->name('edit');
            Route::get('/delete', [CurrencyController::class, 'delete'])->name('delete');
        });
    });

    Route::group(['prefix' => "articles"],function() {
        Route::get('/', [ArticleController::class, 'index'])->name('articles');
        Route::group(['as' => "articles."], function() {
            Route::any('create', [ArticleController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => '{id}', 'as' => "articles."],function() {
            Route::match(['get', 'post'], '/edit', [ArticleController::class, 'edit'])->name('edit');
            Route::get('/delete', [ArticleController::class, 'delete'])->name('delete');
        });
    });
});

require __DIR__.'/auth.php';
