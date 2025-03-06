<?php

use App\Http\Controllers\InternController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/interns', [InternController::class, 'index']);

Route::post('/interns', [InternController::class, 'store']);

Route::get('/interns/{intern}', [InternController::class, 'show']);
