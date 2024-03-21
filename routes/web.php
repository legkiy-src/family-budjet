<?php

use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\CurrencyController;
use App\Http\Controllers\Web\ExpenseController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\Web\RevenueController;
use App\Http\Controllers\Web\AccountController;
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

/*Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    echo "Кэш очищен."; exit;
});*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/operations{id?}', [OperationController::class, 'index'])->name('operations');

Route::get('/reports', function () {
    return view('reports.reports');
})->middleware(['auth'])->name('reports');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => "accounts"],function() {
        Route::get('/', [AccountController::class, 'index'])->name('accounts');
        Route::group(['as' => "accounts."], function() {
            Route::get('create', [AccountController::class, 'create'])->name('create');
            Route::post('store', [AccountController::class, 'store'])->name('store');
            Route::get('{id}/edit', [AccountController::class, 'edit'])
                ->name('edit')
                ->where('id', '[0-9]+');
            Route::post('update', [AccountController::class, 'update'])->name('update');
            Route::get('{id}/destroy', [AccountController::class, 'destroy'])
                ->name('destroy')
                ->where('id', '[0-9]+');
        });
    });

    Route::group(['prefix' => "currencies"],function() {
        Route::get('/', [CurrencyController::class, 'index'])->name('currencies');
        Route::group(['as' => "currencies."], function() {
            Route::any('create', [CurrencyController::class, 'create'])->name('create');
            Route::post('store', [CurrencyController::class, 'store'])->name('store');
            Route::get('{id}/edit', [CurrencyController::class, 'edit'])
                ->name('edit')
                ->where('id', '[0-9]+');
            Route::post('update', [CurrencyController::class, 'update'])->name('update');
            Route::get('{id}/destroy', [CurrencyController::class, 'destroy'])
                ->name('destroy')
                ->where('id', '[0-9]+');
        });
    });

    Route::group(['prefix' => "articles"],function() {
        Route::get('/', [ArticleController::class, 'index'])->name('articles');
        Route::group(['as' => "articles."], function() {
            Route::get('create', [ArticleController::class, 'create'])->name('create');
            Route::post('store', [ArticleController::class, 'store'])->name('store');
            Route::get('{id}/edit', [ArticleController::class, 'edit'])
                ->name('edit')
                ->where('id', '[0-9]+');
            Route::post('update', [ArticleController::class, 'update'])->name('update');
            Route::get('{id}/destroy', [ArticleController::class, 'destroy'])
                ->name('destroy')
                ->where('id', '[0-9]+');
        });
    });

    Route::group(['prefix' => "revenues"],function() {
        Route::get('/', [RevenueController::class, 'index'])->name('revenues');
        Route::group(['as' => "revenues."], function() {
            Route::get('create', [RevenueController::class, 'create'])->name('create');
            Route::post('store', [RevenueController::class, 'store'])->name('store');
            Route::get('{id}/edit', [RevenueController::class, 'edit'])
                ->name('edit')
                ->where('id', '[0-9]+');
            Route::post('update', [RevenueController::class, 'update'])->name('update');
            Route::get('{id}/destroy', [RevenueController::class, 'destroy'])
                ->name('destroy')
                ->where('id', '[0-9]+');
        });
    });

    Route::group(['prefix' => "expenses"],function() {
        Route::get('/', [ExpenseController::class, 'index'])->name('expenses');
        Route::group(['as' => "expenses."], function() {
            Route::get('create', [ExpenseController::class, 'create'])->name('create');
            Route::post('store', [ExpenseController::class, 'store'])->name('store');
            Route::get('{id}/edit', [ExpenseController::class, 'edit'])
                ->name('edit')
                ->where('id', '[0-9]+');
            Route::post('update', [ExpenseController::class, 'update'])->name('update');
            Route::get('{id}/destroy', [ExpenseController::class, 'destroy'])
                ->name('destroy')
                ->where('id', '[0-9]+');
        });
    });
});

require __DIR__.'/auth.php';
