<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InternalController;

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

Route::get('/', [InternalController::class, 'index'])->name('internal');
Route::get('/internal/create', [InternalController::class, 'edit'])->name('internal.edit');
Route::put('/', [InternalController::class, 'update'])->name('internal.update');
Route::get('/discount-internal', [InternalController::class, 'show'])->name('discount.internal');

Route::get('/discount', [DiscountController::class, 'index'])->name('discount');
Route::get('/discount/{$id}', [DiscountController::class, 'show'])->name('discount.show');
Route::get('/exportdiscount', [DiscountController::class, 'export'])->name('exportdiscount');
Route::post('/importdiscount', [DiscountController::class, 'import'])->name('importdiscount');

// Route::get('/', function () {
//     return view('welcome');
// });
