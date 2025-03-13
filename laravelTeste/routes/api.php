<?php

use App\Http\Controllers\InternController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('api');

Route::post('/register', [JWTAuthController::class, 'register']);

Route::post('/login', [JWTAuthController::class, 'login']);


Route::middleware([JwtMiddleware::class])->group(function (){
    Route::get('/user', [JWTAuthController::class, 'getUser']);

    Route::get('/logout', [JWTAuthController::class, 'logout']);
    Route::get('/interns', [InternController::class, 'index']);

    Route::post('/interns', [InternController::class, 'store']);

    Route::get('/interns/{intern}', [InternController::class, 'show']);

    Route::post('/interns/update/{intern}/{phone}', [InternController::class, 'update']);

    Route::post('/interns/delete/{intern}', [InternController::class, 'destroy']);

    Route::get('/interns/findByName/{name}', [InternController::class, 'showByName']);
});