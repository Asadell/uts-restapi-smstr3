<?php

use App\Http\Controllers\DepartemenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/departemen', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('departemen', DepartemenController::class);
