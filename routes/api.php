<?php

use App\Http\Controllers\JarApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->prefix('jar')->group(function(){
    Route::get('/{jar?}',[JarApiController::class,'show'])->name('api-jar-show');
    Route::post('/',[JarApiController::class,'store'])->name('api-jar-store');
    Route::put('/{jar}',[JarApiController::class,'update'])->name('api-jar-update');
    Route::delete('/{jar}',[JarApiController::class,'delete'])->name('api-jar-delete');
});