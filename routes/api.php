<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\ProductController;
use App\Http\Controllers\Apis\Auth\LoginController;
use App\Http\Controllers\APis\Auth\ProfileController;
use App\Http\Controllers\Apis\Auth\RegisterController;

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


// get , no inputs , all products
Route::middleware(['accept','lang'])->group(function(){
    Route::prefix('products')->middleware('auth:sanctum')->controller(ProductController::class)->group(function(){
        Route::get('/','index');
        Route::get('/create','create');
        Route::post('/store','store');
        Route::get('/edit/{id}','edit');
        Route::post('/update/{id}','update');
        Route::post('/delete/{id}','delete');
    });

    Route::prefix('admins')->group(function(){
        Route::post('register',RegisterController::class);
        Route::post('login',[LoginController::class,'login']);
        Route::middleware('auth:sanctum')->group(function(){
            Route::post('logout-all',[LoginController::class,'logoutAll']);
            Route::post('logout-current',[LoginController::class,'logoutCurrent']);
            Route::post('logout-other',[LoginController::class,'logoutOther']);
            Route::get('profile',ProfileController::class);
        });
    });
});

// Route::get('test',function(){
//     return response()->json(config('auth.guards'));
// });
