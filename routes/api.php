<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(InvoiceController::class)->prefix('invoices')->name('invoices.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/search', 'searchInvoice')->name('search');
    Route::get('/create', 'create')->name('create');
});

Route::controller(CustomerController::class)->prefix('customers')->name('customers.')->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(ProductController::class)->prefix('products')->name('products.')->group(function () {
    Route::get('/', 'index')->name('index');
});