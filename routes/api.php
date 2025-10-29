<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourierAuthController;
use App\Http\Controllers\Api\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::post('/courier/login', [CourierAuthController::class, 'login']);

Route::post('/courier-location', function (Request $request) {
    DB::table('courier_tracking')->insert([
        'courier_id' => 1, // hardcode sementara
        'date' => now()->toDateString(),
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'Lokasi berhasil disimpan']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/delivery/{id}/route', [RouteController::class, 'getRoute']);
});


Route::middleware('auth:courier')->get('/deliveries', [RouteController::class, 'getAllDeliveries']);
