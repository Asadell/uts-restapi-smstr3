<?php

use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\JabatanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('departemen', DepartemenController::class);
Route::apiResource('jabatan', JabatanController::class,);
