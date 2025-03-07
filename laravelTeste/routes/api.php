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

Route::post('/interns/update/{intern}/{phone}', [InternController::class, 'update']);

Route::post('/interns/delete/{intern}', [InternController::class, 'destroy']);

Route::get('/interns/findByName/{name}', [InternController::class, 'showByName']);