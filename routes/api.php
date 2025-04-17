<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/testpass', function(Request $request){
    $user = User::find(1);
    $token = $user->createToken('mobile-app-token')->accessToken;
    dd($token);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:api')->group(function () {
    Route::apiResource('products', ProductController::class);
});
