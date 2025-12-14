<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/test', function(Request $request) {
    return response()->json([
        "message" => "API TEST",
    ], 200);
});

ROute::post('/login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
