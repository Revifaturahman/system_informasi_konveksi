<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CutterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryToCutterController;
use App\Http\Controllers\DeliveryToObrasController;
use App\Http\Controllers\DeliveryToTailorController;
use App\Http\Controllers\ObrasController;
use App\Http\Controllers\OverdeckController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\TailorController;
use App\Models\DeliveryToObras;
use App\Models\DeliveryToTailor;
use App\Models\ProductVariant;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 🤖 API Gemini (dipanggil lewat fetch JS)
Route::get('/api/gemini', [DashboardController::class, 'geminiApi'])->name('dashboard.gemini');

Route::prefix('employe')->group(function () {
    Route::resource('courier', CourierController::class);
    Route::resource('tailor', TailorController::class);
    Route::resource('cutter', CutterController::class);
    Route::resource('overdeck', OverdeckController::class);
    Route::resource('obras', ObrasController::class);
    // Route::view('/cutter', 'employe.cutter')->name('employe.cutter');
    // Route::view('/overdeck', 'employe.overdeck')->name('employe.overdeck');
    // Route::view('/obras', 'employe.obras')->name('employe.obras');
});

Route::prefix('operation')->group(function () {
    // To Penjahit
    Route::resource('delivery-to-tailor', DeliveryToTailorController::class);
    Route::post('delivery-to-tailor/{id}/take-result', [DeliveryToTailorController::class, 'takeResult'])
    ->name('delivery-to-tailor.take-result');
    Route::post('/delivery-to-tailor/{id}/start-pickup', [DeliveryToTailorController::class, 'startPickup'])->name('delivery-to-tailor.start-pickup');
    Route::post('/delivery-to-tailor/{id}/finish-pickup', [DeliveryToTailorController::class, 'finishPickup'])->name('delivery-to-tailor.finish-pickup');


    // To Obras
    Route::resource('delivery-to-obras', DeliveryToObrasController
    ::class);
    Route::post('delivery-to-obras/{id}/take-result', [DeliveryToObrasController::class, 'takeResult'])
    ->name('delivery-to-obras.take-result');

    // To Cutter
    Route::resource('delivery-to-cutter', DeliveryToCutterController::class);
    Route::post('delivery-to-cutter/{id}/take-result', [DeliveryToCutterController::class, 'takeResult'])
    ->name('delivery-to-cutter.take-result');
    // Route::view('/delivery-to-cutter', 'operation.delivery-to-cutter')->name('operation.delivery-to-cutter');
    
    Route::view('/clouthe-in', 'operation.clouthe-in')->name('operation.clouthe-in');
    Route::view('/clouthe-out', 'operation.clouthe-out')->name('operation.clouthe-out');
});

Route::prefix('product')->group(function () {
    // PRODUCT
    Route::resource('product', ProductController::class);

    // PRODUCT CATEGORY
    Route::resource('product-category', ProductCategoryController::class);

    // PRODUCT VARIANT
    Route::resource('product-variant', ProductVariantController::class);
    // Route::view('/variant', 'product.product-variant')->name('produk.variant');
});

Route::prefix('report')->group(function () {
    Route::view('/tailor', 'report.tailor')->name('report.tailor');
    Route::view('/cutter', 'report.cutter')->name('report.cutter');
    Route::view('/obras', 'report.obras')->name('report.obras');
    Route::view('/overdeck', 'report.overdeck')->name('report.overdeck');
    Route::view('/sale', 'report.sale')->name('report.sale');
});

Route::prefix('tracking')->group(function () {
    Route::view('/tracking', 'tracking.tracking')->name('tracking.tracking');
});



