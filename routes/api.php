<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers\API\v1\Auth'], function() {
    Route::get('/sessionExpired', function(){
        return response()->json(
            [
                "data" => (Object) array(),
                "message" => "Session Expired.",                    
                "status"  => 401
            ], 
            401
        );
    });
});

require __DIR__.'/api/routes.php';